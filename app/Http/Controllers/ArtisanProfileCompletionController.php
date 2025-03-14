<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArtisanProfileCompletionController extends Controller
{
    public function show()
    {
        return view('artisan.complete-profile', [
            'user' => auth()->user(),
            'specialties' => [
                'plomberie' => 'Plomberie',
                'electricite' => 'Électricité',
                'maconnerie' => 'Maçonnerie',
                'peinture' => 'Peinture',
                'menuiserie' => 'Menuiserie',
                // Ajoutez d'autres spécialités...
            ]
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'business_name' => 'required|string|min:2',
                'siret' => 'required|string|size:14|unique:artisans',
                'specialty' => 'required|string',
                'description' => 'required|string|min:100',
                'experience_years' => 'required|integer|min:0',
                'hourly_rate' => 'required|numeric|min:0',
                'service_area' => 'required|string',
                'payment_methods' => 'required|array|min:1',
                'documents.decennial_insurance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'documents.professional_insurance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'documents.qualification_certificates' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'documents.company_registration' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'terms_accepted' => 'required|accepted',
                'privacy_accepted' => 'required|accepted'
            ]);

            DB::beginTransaction();

            // Stockage des documents
            $documents = [];
            foreach ($request->file('documents') as $type => $file) {
                $path = $file->store('artisan-documents/' . auth()->id(), 'private');
                $documents[$type] = $path;
            }

            // Création du profil artisan
            $artisan = Artisan::create([
                'user_id' => auth()->id(),
                'business_name' => $validated['business_name'],
                'siret' => $validated['siret'],
                'specialty' => $validated['specialty'],
                'description' => $validated['description'],
                'experience_years' => $validated['experience_years'],
                'hourly_rate' => $validated['hourly_rate'],
                'service_area' => $validated['service_area'],
                'payment_methods' => $validated['payment_methods'],
                'documents' => $documents,
                'status' => 'pending_verification'
            ]);

            // Mise à jour du statut de l'utilisateur
            auth()->user()->update([
                'profile_completed' => true
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profil complété avec succès',
                'redirect' => route('artisan.projects.available')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création du profil artisan', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de votre profil'
            ], 500);
        }
    }
}

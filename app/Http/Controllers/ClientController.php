<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Ajout de l'import manquant

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        $projects = $user->projects()
            ->latest()
            ->get()
            ->map(function ($project) {
                // Assurons-nous que photos est un tableau
                $project->photos = is_string($project->photos) ? json_decode($project->photos, true) : [];
                return $project;
            });

        $statistics = [
            'total_projects' => $projects->count(),
            'completed_projects' => $projects->where('status', 'completed')->count(),
            'pending_projects' => $projects->where('status', 'pending')->count(),
            'unread_messages' => Message::where('recipient_id', $user->id)
                ->where('is_read', false)
                ->count()
        ];

        return view('client.dashboard', compact('user', 'projects', 'statistics'));
    }

    public function showCompleteProfile()
    {
        return view('client.complete-profile', [
            'user' => auth()->user(),
            'steps' => [
                'personal' => 'Informations personnelles',
                'contact' => 'Coordonnées',
                'preferences' => 'Préférences'
            ]
        ]);
    }

    public function completeProfile(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|min:10',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'preferred_contact_method' => 'required|in:email,phone',
            'notify_new_quotes' => 'boolean'
        ]);

        auth()->user()->update($validated);

        return redirect()->route('client.dashboard')
            ->with('success', 'Profil complété avec succès !');
    }
}

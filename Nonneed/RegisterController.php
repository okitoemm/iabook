<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showClientRegistrationForm()
    {
        return view('auth.register_client');
    }

    public function showArtisanRegistrationForm()
    {
        return view('auth.register_artisan');
    }

    public function registerClient(Request $request)
    {
        $messages = [
            'name.required' => 'Votre nom est requis pour créer un compte.',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
            'password.min' => 'Le mot de passe doit faire au moins 8 caractères pour votre sécurité.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'city.required' => 'Votre ville est nécessaire pour trouver des artisans près de chez vous.',
            'postal_code.required' => 'Le code postal est nécessaire pour la localisation.',
            'terms.accepted' => 'Vous devez accepter les conditions générales pour continuer.',
        ];

        $validated = $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'city' => 'required',
            'postal_code' => 'required',
            'terms' => 'required|accepted'
        ], $messages);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'city' => $validated['city'],
            'role' => 'client'
        ]);

        return redirect()->route('login')
            ->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }

    public function registerArtisan(Request $request)
    {
        return app(\App\Http\Controllers\ArtisanController::class)->store($request);
    }
}
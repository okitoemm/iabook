<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/';  // Change from /home to /

    public function showLoginForm()
    {
        $testimonials = [
            [
                'name' => 'Jean Martin',
                'avatar' => 'https://ui-avatars.com/api/?name=Jean+Martin',
                'comment' => 'Excellent service, travail soigné et professionnel.'
            ],
            [
                'name' => 'Marie Dubois',
                'avatar' => 'https://ui-avatars.com/api/?name=Marie+Dubois',
                'comment' => 'Intervention rapide et efficace. Je recommande!'
            ],
            [
                'name' => 'Pierre Durand',
                'avatar' => 'https://ui-avatars.com/api/?name=Pierre+Durand',
                'comment' => 'Très satisfait du travail réalisé.'
            ]
        ];

        return view('auth.login', compact('testimonials'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirection selon le rôle
            return redirect()->intended(
                auth()->user()->isArtisan() 
                    ? route('artisan.dashboard')
                    : route('client.dashboard')
            );
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
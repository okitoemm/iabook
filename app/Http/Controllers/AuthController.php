<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if ($request->has('type') && in_array($request->type, ['client', 'artisan'])) {
            return view('auth.register');
        }
        return view('auth.register-choice');
    }

    public function registerClient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'client'
        ]);

        auth()->login($user);

        return redirect()->route('client.dashboard');
    }

    public function registerArtisan(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => 'required|string|max:255',
            'siret' => 'required|string|unique:artisans',
            'specialty' => 'required|string',
            'description' => 'required|string',
            'experience_years' => 'required|integer',
            'hourly_rate' => 'required|numeric',
            'service_area' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'artisan'
        ]);

        $artisan = Artisan::create([
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'siret' => $validated['siret'],
            'specialty' => $validated['specialty'],
            'description' => $validated['description'],
            'experience_years' => $validated['experience_years'],
            'hourly_rate' => $validated['hourly_rate'],
            'service_area' => $validated['service_area'],
        ]);

        auth()->login($user);

        return redirect()->route('artisan.dashboard');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isArtisan()) {
                return redirect()->route('artisan.dashboard');
            }
            
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 
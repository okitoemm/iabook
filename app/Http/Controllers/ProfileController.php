<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        if ($user->role === 'client') {
            return view('client.profile', compact('user'));
        }
        
        return view('artisan.profile', [
            'user' => $user,
            'profile' => $user->artisan
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        if ($user->role === 'artisan') {
            $profile = $user->artisan;
        }
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'city' => 'required|string|max:100',
            'password' => 'nullable|min:8|confirmed',
            // Artisan specific fields
            'business_name' => Rule::requiredIf($user->role === 'artisan'),
            'specialty' => Rule::requiredIf($user->role === 'artisan'),
            'description' => Rule::requiredIf($user->role === 'artisan'),
            'experience_years' => Rule::requiredIf($user->role === 'artisan'),
            'hourly_rate' => Rule::requiredIf($user->role === 'artisan'),
            'service_area' => Rule::requiredIf($user->role === 'artisan'),
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        if ($user->role === 'artisan') {
            $user->artisan->update([
                'business_name' => $validated['business_name'],
                'specialty' => $validated['specialty'],
                'description' => $validated['description'],
                'experience_years' => $validated['experience_years'],
                'hourly_rate' => $validated['hourly_rate'],
                'service_area' => $validated['service_area'],
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
}

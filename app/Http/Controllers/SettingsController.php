<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function show()
    {
        return view('settings.index', [
            'user' => auth()->user(),
            'isGoogleUser' => !empty(auth()->user()->google_id)
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Le mot de passe actuel est incorrect.');
                }
            }],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Mot de passe mis à jour avec succès');
    }

    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'newsletter' => 'boolean'
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Préférences de notifications mises à jour');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:DELETE'
        ]);

        $user = auth()->user();
        
        // Soft delete pour garder l'historique
        $user->update(['status' => 'deleted']);
        $user->delete();

        auth()->logout();
        return redirect('/')->with('success', 'Votre compte a été supprimé');
    }
}

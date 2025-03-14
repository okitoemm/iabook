<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        // Stocker l'intention de rôle dans la session
        if ($request->has('role')) {
            session(['intended_role' => $request->role]);
        }
        
        
        return Socialite::driver('google')
            ->with(['access_type' => 'offline', 'prompt' => 'select_account'])
            ->scopes(['email', 'profile'])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            \Log::info('Google user data', [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId()
            ]);
            
            $user = User::where('email', $googleUser->getEmail())
                       ->orWhere('google_id', $googleUser->getId())
                       ->first();
            
            if (!$user) {
                DB::beginTransaction();
                try {
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'password' => \Hash::make(uniqid()),
                        'email_verified_at' => now()
                    ]);
                    DB::commit();
                    
                    \Log::info('New user created', ['user_id' => $user->id]);
                    
                    auth()->login($user);
                    return redirect()->route('role.select');
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
            }

            auth()->login($user);
            
            return $user->role
                ? redirect()->route($user->role . '.dashboard')
                : redirect()->route('role.select');

        } catch (\Exception $e) {
            \Log::error('Google auth error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Une erreur est survenue lors de la connexion avec Google');
        }
    }
}

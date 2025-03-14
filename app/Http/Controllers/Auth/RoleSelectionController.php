<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RoleSelectionController extends Controller
{
    public function show()
    {
        return view('auth.select-role');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:client,artisan'
        ]);

        try {
            \Log::info('Starting role update', [
                'user_id' => auth()->id(),
                'role' => $validated['role']
            ]);

            $user = User::findOrFail(auth()->id());
            
            // Mise à jour directe du rôle
            $updated = $user->forceFill([
                'role' => $validated['role']
            ])->save();

            if (!$updated) {
                throw new \Exception('Failed to update role');
            }

            \Log::info('Role updated successfully', [
                'user' => $user->fresh()->toArray()
            ]);

            return redirect()->route($validated['role'] . '.complete-profile')
                ->with('success', 'Rôle sélectionné avec succès');

        } catch (\Exception $e) {
            \Log::error('Role update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Erreur lors de la mise à jour du rôle');
        }
    }
}

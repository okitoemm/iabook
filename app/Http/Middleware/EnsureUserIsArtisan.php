<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnsureUserIsArtisan
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Middleware EnsureUserIsArtisan is running', [
            'authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? null
        ]);

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'artisan') {
            return redirect()->route('login')
                ->with('error', 'Cette section est réservée aux artisans.');
        }

        return $next($request);
    }
}

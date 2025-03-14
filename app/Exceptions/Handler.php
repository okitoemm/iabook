// ...existing code...

public function register()
{
    $this->renderable(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Action non autorisée'
            ], 403);
        }

        return redirect()->route('home')->with('error', 'Action non autorisée');
    });
}

// ...existing code...

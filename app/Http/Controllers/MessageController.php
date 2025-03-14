<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('messages.index');
    }

    public function show($user)
    {
        return view('messages.show', compact('user'));
    }

    public function store(Request $request, Project $project)
    {
        try {
            $message = Message::create([
                'sender_id' => auth()->id(),
                'recipient_id' => $project->client_id,
                'project_id' => $project->id,
                'content' => $request->message,
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message envoyé avec succès'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du message', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du message'
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectFeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('artisan');
    }

    public function index(Request $request)
    {
        $query = Project::with(['client', 'media'])
            ->where('status', 'open')
            ->latest();

        // Filtrage par ville
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Filtrage par code postal
        if ($request->filled('postal_code')) {
            $query->where('postal_code', 'like', $request->postal_code . '%');
        }

        // Recherche
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $projects = $query->paginate(12)
            ->withQueryString();

        return view('projects.feed', [
            'projects' => $projects,
            'cities' => Project::distinct('city')->pluck('city'),
            'filters' => $request->only(['city', 'postal_code', 'search'])
        ]);
    }

    public function show(Project $project)
    {
        $project->load(['client', 'media', 'messages']);
        
        return view('projects.show', [
            'project' => $project,
            'canContact' => auth()->user()->isArtisan()
        ]);
    }

    public function contact(Project $project, Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|min:50',
            'estimated_price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1'
        ]);

        $message = $project->messages()->create([
            'sender_id' => auth()->id(),
            'content' => $validated['message'],
            'estimated_price' => $validated['estimated_price'],
            'estimated_days' => $validated['estimated_days']
        ]);

        return back()->with('success', 'Votre proposition a été envoyée.');
    }
}

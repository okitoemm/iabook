<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Ajout de l'import pour DB
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        if (!auth()->user()->role === 'client') {
            abort(403, 'Seuls les clients peuvent créer des projets.');
        }
        
        return view('projects.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->role === 'client') {
            return response()->json([
                'success' => false,
                'message' => 'Seuls les clients peuvent créer des projets.'
            ], 403);
        }

        $this->authorize('create', Project::class);
        
        try {
            $formData = json_decode($request->input('formData'), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON format in formData');
            }

            // Validate request
            $request->validate([
                'formData' => 'required|json',
                'photos' => 'required|array',
                'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'video' => 'nullable|mimes:mp4,mov,avi|max:20480'
            ]);

            // Handle files
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('projects/photos', 'public');
                $photos[] = $path;
            }

            $videoPath = null;
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('projects/videos', 'public');
            }

            // Create project with proper photo array
            $project = Project::create([
                'client_id' => auth()->id(),
                'title' => $formData['title'],
                'description' => $formData['description'],
                'category' => $formData['category'] ?? 'other',
                'budget' => $formData['budget'],
                'budget_type' => $formData['budget_type'],
                'city' => $formData['city'],
                'postal_code' => $formData['postal_code'],
                'address' => $formData['address'],
                'urgent' => $formData['urgent'],
                'verification_method' => $formData['verification_method'],
                'availability_days' => $formData['availability_days'],
                'availability_hours' => $formData['availability_hours'],
                'photos' => $photos, // This will be automatically JSON encoded by the model cast
                'video_path' => $videoPath,
                'status' => 'open'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Projet créé avec succès',
                'project' => $project
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Project creation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except('photos', 'video') // Don't log file contents
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du projet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        \Log::info('Affichage du projet', ['project_id' => $project->id]);
        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function available()
    {
        // Stats des projets
        $stats = [
            'total' => Project::count(),
            'urgent' => Project::where('urgent', true)->count(),
            'by_category' => Project::select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->pluck('count', 'category'),
            'by_city' => Project::select('city', DB::raw('count(*) as count'))
                ->groupBy('city')
                ->pluck('count', 'city'),
            'avg_budget' => Project::whereNotNull('budget')->avg('budget'),
        ];

        $cities = ['Paris', 'Lyon', 'Marseille', 'Bordeaux', 'Lille', 'Toulouse'];
        
        $projects = Project::query()
            ->when(request('category'), function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when(request('city'), function ($query, $city) {
                return $query->where('city', $city);
            })
            ->when(request('urgent'), function ($query) {
                return $query->where('urgent', true);
            })
            ->latest()
            ->paginate(15);

        return view('projects.available', compact('projects', 'cities', 'stats'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artisan;
use App\Models\Project; // Ajout de l'import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ArtisanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['dashboard']);
    }

    public function show($id)
    {
        // Données statiques temporaires enrichies
        $artisan = (object)[
            'user' => (object)[
                'name' => 'Jean Dupont ' . $id,
                'company_name' => 'Dupont & Fils SARL',
                'verified' => true,
                'pro_badge' => true,
                'member_since' => '2020'
            ],
            'user_id' => $id,
            'specialty' => 'Plomberie',
            'description' => 'Plombier professionnel avec plus de 10 ans d\'expérience. Spécialisé dans la rénovation de salles de bain et l\'installation de systèmes de chauffage écologiques. Notre équipe qualifiée intervient sur Paris et sa région.',
            'service_area' => 'Paris et environs',
            'experience_years' => 10,
            'hourly_rate' => '50',
            'total_reviews' => 25,
            'rating_average' => 4.8,
            'certifications' => [
                ['name' => 'RGE Qualibat', 'year' => '2022'],
                ['name' => 'Artisan d\'Art', 'year' => '2021'],
                ['name' => 'Professionnel du Gaz', 'year' => '2020']
            ],
            'completed_projects' => 127,
            'response_time' => '2h',
            'portfolio' => [
                [
                    'title' => 'Rénovation salle de bain complète',
                    'image' => 'https://source.unsplash.com/800x600/?bathroom',
                    'description' => 'Rénovation complète avec douche à l\'italienne',
                    'date' => '2023'
                ],
                [
                    'title' => 'Installation chauffage écologique',
                    'image' => 'https://source.unsplash.com/800x600/?heating',
                    'description' => 'Pompe à chaleur dernière génération',
                    'date' => '2023'
                ],
                [
                    'title' => 'Dépannage urgent',
                    'image' => 'https://source.unsplash.com/800x600/?plumbing',
                    'description' => 'Intervention rapide suite à une fuite',
                    'date' => '2023'
                ]
            ],
            'insurances' => [
                'Responsabilité civile professionnelle',
                'Garantie décennale',
                'Dommages-ouvrage'
            ],
            'payment_methods' => ['CB', 'Chèque', 'Virement', 'Espèces'],
            'services' => [
                'Plomberie générale',
                'Installation sanitaire',
                'Chauffage',
                'Dépannage urgent',
                'Rénovation salle de bain'
            ],
            'availability' => [
                'Lundi au Vendredi: 8h-19h',
                'Samedi: 9h-16h',
                'Urgences 24/7'
            ]
        ];

        return view('artisans.show', compact('artisan'));
    }

    public function contact($id)
    {
        return view('artisans.contact', [
            'artisan' => (object)[
                'name' => 'Jean Dupont ' . $id,
                'specialty' => 'Plomberie'
            ]
        ]);
    }

    public function dashboard()
    {
        try {
            $user = auth()->user();
            
            // Vérifier si l'utilisateur a un profil artisan
            if (!$user->artisan) {
                \Log::warning('Artisan profile not found for user', ['user_id' => $user->id]);
                
                // Créer un profil artisan vide si nécessaire
                $artisan = new Artisan([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'rating_average' => 0,
                    'total_reviews' => 0
                ]);
                $user->artisan()->save($artisan);
                
                // Rediriger vers la page de complétion du profil
                return redirect()->route('artisan.complete-profile')
                    ->with('warning', 'Veuillez compléter votre profil pour accéder à votre tableau de bord');
            }

            $reviews = $user->artisan->reviews()->latest()->paginate(10);
            
            $cities = ['Paris', 'Lyon', 'Marseille', 'Bordeaux', 'Lille', 'Toulouse'];
            
            // Ajouter le compteur de nouveaux projets
            $newProjectsCount = Project::where('status', 'open')
                ->where('created_at', '>', now()->subDays(7))
                ->count();

            // Déterminer l'onglet actif
            $currentTab = request()->tab ?? (request()->segment(2) ?? 'overview');

            // Récupérer les projets disponibles
            $projects = Project::query()  // Utiliser query() pour construire la requête
                ->where('status', 'open')
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
                ->paginate(10);  // Utiliser paginate() au lieu de get()

            return view('artisan.dashboard', compact('cities', 'reviews', 'projects', 'newProjectsCount', 'currentTab'));
        } catch (\Exception $e) {
            \Log::error('Error in artisan dashboard', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return view('artisan.dashboard', [
                'artisan' => null,
                'reviews' => collect([]),
                'projects' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10), // Pagination vide
                'currentTab' => 'overview',
                'newProjectsCount' => 0,
                'stats' => []
            ])->with('error', 'Une erreur est survenue lors du chargement de votre tableau de bord');
        }
    }

    public function store(Request $request)
    {
        \Log::info('Artisan registration started', $request->all());
        
        try {
            if (empty($request->all())) {
                return back()->withErrors([
                    'name' => 'Votre nom est requis pour créer un compte.',
                    'email' => 'L\'adresse email est obligatoire.',
                    'password' => 'Le mot de passe est obligatoire.',
                    'phone' => 'Le numéro de téléphone est nécessaire pour être contacté par les clients.',
                    'business_name' => 'Le nom de votre entreprise est obligatoire.',
                    'siret' => 'Le numéro SIRET est obligatoire pour exercer en tant qu\'artisan.',
                    'specialty' => 'Veuillez indiquer votre spécialité principale.',
                    'description' => 'Une description de votre activité est nécessaire.',
                    'experience_years' => 'Indiquez vos années d\'expérience.',
                    'hourly_rate' => 'Veuillez indiquer votre taux horaire.',
                    'service_area' => 'Veuillez préciser votre zone d\'intervention.',
                    'terms' => 'Vous devez accepter les conditions générales pour continuer.'
                ]);
            }

            \Log::info('Starting artisan registration', $request->all());

            // Prétraitement du SIRET
            $siret = preg_replace('/[^0-9]/', '', $request->input('siret'));
            $request->merge(['siret' => $siret]);

            // Vérifications préliminaires
            if (Artisan::where('siret', $siret)->exists()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'siret' => 'Ce numéro SIRET est déjà enregistré dans notre système.'
                    ]);
            }

            if (User::where('email', $request->input('email'))->exists()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'email' => 'Cette adresse email est déjà utilisée. Veuillez vous connecter ou utiliser une autre adresse.'
                    ]);
            }

            // Vérification préliminaire du mot de passe
            $password = $request->input('password');
            $passwordValidation = $this->validatePassword($password);
            
            if (!$passwordValidation['valid']) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'password' => $passwordValidation['errors']
                    ]);
            }

            $messages = [
                'name.required' => 'Votre nom est requis pour créer un compte.',
                'name.min' => 'Votre nom doit contenir au moins 2 caractères.',
                'email.required' => 'L\'adresse email est obligatoire.',
                'email.email' => 'Veuillez entrer une adresse email valide.',
                'email.unique' => 'Cette adresse email est déjà utilisée. Veuillez en choisir une autre ou vous connecter.',
                'phone.required' => 'Le numéro de téléphone est nécessaire pour être contacté par les clients.',
                'phone.unique' => 'Ce numéro de téléphone est déjà utilisé par un autre compte.',
                'business_name.required' => 'Le nom de votre entreprise est obligatoire.',
                'siret.required' => 'Le numéro SIRET est obligatoire pour exercer en tant qu\'artisan.',
                'siret.size' => 'Le numéro SIRET doit contenir exactement 14 chiffres.',
                'siret.unique' => 'Ce numéro SIRET est déjà enregistré. Si c\'est votre entreprise, veuillez nous contacter.',
                'siret.numeric' => 'Le SIRET ne doit contenir que des chiffres (0-9).',
                'specialty.required' => 'Veuillez indiquer votre spécialité principale.',
                'description.required' => 'Une description de votre activité est nécessaire.',
                'description.min' => 'Votre description doit faire au moins :min caractères.',
                'experience_years.required' => 'Indiquez vos années d\'expérience.',
                'experience_years.integer' => 'Le nombre d\'années d\'expérience doit être un nombre entier.',
                'experience_years.min' => 'Le nombre d\'années d\'expérience ne peut pas être négatif.',
                'hourly_rate.required' => 'Veuillez indiquer votre taux horaire.',
                'hourly_rate.numeric' => 'Le taux horaire doit être un nombre.',
                'hourly_rate.min' => 'Le taux horaire doit être supérieur à 0.',
                'service_area.required' => 'Veuillez préciser votre zone d\'intervention.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
                'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',
                'password.mixed' => 'Le mot de passe doit contenir un mélange de majuscules, minuscules et chiffres.',
                'password_confirmation.required' => 'La confirmation du mot de passe est obligatoire.',
                'password_confirmation.same' => 'Les deux mots de passe doivent être identiques.',
                'terms.accepted' => 'Vous devez accepter les conditions générales pour continuer.',
            ];

            // Validation préliminaire de la description
            if ($request->filled('description')) {
                $descriptionLength = strlen($request->input('description'));
                $wordCount = str_word_count($request->input('description'));
                
                if ($descriptionLength < 100 || $wordCount < 20) {
                    $errors = [];
                    if ($descriptionLength < 100) {
                        $errors[] = sprintf(
                            'Il manque %d caractères pour atteindre le minimum requis de 100 caractères.',
                            100 - $descriptionLength
                        );
                    }
                    if ($wordCount < 20) {
                        $errors[] = sprintf(
                            'Il manque %d mots pour atteindre le minimum requis de 20 mots.',
                            20 - $wordCount
                        );
                    }
                    
                    return back()
                        ->withInput()
                        ->withErrors(['description' => $errors]);
                }
            }

            $validated = $request->validate([
                'name' => 'required|min:2|string',
                'email' => 'required|email|unique:users',
                'password' => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/[A-Z]/', $value)) {
                            $fail('Le mot de passe doit contenir au moins une lettre majuscule.');
                        }
                        if (!preg_match('/[a-z]/', $value)) {
                            $fail('Le mot de passe doit contenir au moins une lettre minuscule.');
                        }
                        if (!preg_match('/[0-9]/', $value)) {
                            $fail('Le mot de passe doit contenir au moins un chiffre.');
                        }
                    },
                ],
                'password_confirmation' => 'required|same:password',
                'phone' => 'required|unique:users|regex:/^[0-9+\s\-()]{8,}$/',
                'business_name' => 'required|string|min:2',
                'siret' => [
                    'required',
                    'string',
                    'size:14',
                    'unique:artisans',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^\d{14}$/', $value)) {
                            $fail('Le SIRET doit contenir exactement 14 chiffres (actuellement : ' . strlen($value) . ' chiffres)');
                        }
                    },
                ],
                'specialty' => 'required|string|min:3',
                'description' => [
                    'required',
                    'min:100',
                    function ($attribute, $value, $fail) {
                        if (str_word_count($value) < 20) {
                            $fail('La description doit contenir au moins 20 mots pour être pertinente.');
                        }
                    }
                ],
                'experience_years' => 'required|integer|min:0',
                'hourly_rate' => 'required|numeric|min:0',
                'service_area' => 'required|string|min:2',
                'terms' => 'required|accepted'
            ], $messages);

            \Log::info('Validation passed', $validated);

            \DB::beginTransaction();

            try {
                \Log::info('Creating user');
                // Créer l'utilisateur
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'phone' => $validated['phone'],
                    'role' => 'artisan'
                ]);

                \Log::info('User created', ['user_id' => $user->id]);

                \Log::info('Creating artisan profile');
                // Créer le profil artisan
                $artisan = Artisan::create([
                    'user_id' => $user->id,
                    'business_name' => $validated['business_name'],
                    'siret' => $validated['siret'],
                    'specialty' => $validated['specialty'],
                    'description' => $validated['description'],
                    'experience_years' => $validated['experience_years'],
                    'hourly_rate' => $validated['hourly_rate'],
                    'service_area' => $validated['service_area'],
                    'is_verified' => false,
                    'rating_average' => 0.00,
                    'total_reviews' => 0
                ]);

                \Log::info('Artisan profile created', ['artisan_id' => $artisan->id]);

                \DB::commit();

                return redirect()->route('login')
                    ->with('success', 'Inscription réussie ! Votre compte est en attente de vérification.');

            } catch (\Exception $e) {
                \DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Error during artisan registration', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['password', 'password_confirmation'])
            ]);

            $errorMessage = $e instanceof \Illuminate\Validation\ValidationException 
                ? $e->errors()
                : ['error' => 'Une erreur est survenue lors de l\'inscription. Veuillez vérifier vos informations et réessayer.'];

            return back()
                ->withInput()
                ->withErrors([
                    'siret' => 'Le format du SIRET est incorrect. Veuillez vérifier votre saisie.',
                    'error' => 'Une erreur est survenue lors de l\'inscription.'
                ])
                ->with('debug_info', [
                    'siret_length' => strlen($request->input('siret')),
                    'siret_format' => $request->input('siret')
                ]);
        }
    }

    private function validatePassword($password)
    {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre minuscule.';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un chiffre.';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    public function index()
    {
        // Données statiques temporaires pour la démo
        $artisans = collect([
            [
                'id' => 1,
                'name' => 'Jean Dupont',
                'specialty' => 'Plomberie',
                'city' => 'Paris',
                'rating' => 4.8,
                'reviews_count' => 124,
                'hourly_rate' => '50€',
                'verified' => true,
                'avatar' => 'https://source.unsplash.com/50x50/?portrait,man'
            ],
            [
                'id' => 2,
                'name' => 'Marie Martin',
                'specialty' => 'Électricité',
                'city' => 'Lyon',
                'rating' => 4.7,
                'reviews_count' => 89,
                'hourly_rate' => '45€',
                'verified' => true,
                'avatar' => 'https://source.unsplash.com/50x50/?portrait,woman'
            ],
            // Ajoutez d'autres artisans si nécessaire
        ]);

        return view('artisans.index', compact('artisans'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'business_name' => 'required|string|min:2',
            'siret' => [
                'required',
                'size:14',
                Rule::unique('artisans')->ignore($user->artisan->id),
                'regex:/^\d{14}$/'
            ],
            'description' => [
                'required',
                'min:100',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) < 20) {
                        $fail('La description doit contenir au moins 20 mots');
                    }
                }
            ],
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'service_area' => 'required|string|min:2',
            'payment_methods' => 'nullable|array',
            'certifications' => 'nullable|array',
            'insurances' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $user->artisan->update($validated);

            DB::commit();

            return back()->with('success', 'Profil mis à jour avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour du profil artisan', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil');
        }
    }

    public function showCompleteProfile()
    {
        $specialties = [
            'plomberie' => 'Plomberie',
            'electricite' => 'Électricité',
            'maconnerie' => 'Maçonnerie',
            'peinture' => 'Peinture',
            'menuiserie' => 'Menuiserie',
            'carrelage' => 'Carrelage',
            'chauffage' => 'Chauffage',
            'isolation' => 'Isolation',
            'toiture' => 'Toiture',
            'renovation' => 'Rénovation générale'
        ];

        return view('artisan.complete-profile', [
            'user' => auth()->user(),
            'specialties' => $specialties
        ]);
    }

    public function completeProfile(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|min:2',
            'siret' => 'required|string|size:14|unique:artisans',
            'specialty' => 'required|string',
            'description' => 'required|string|min:100',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'service_area' => 'required|string',
            'payment_methods' => 'required|array|min:1',
            'documents.decennial_insurance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.professional_insurance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.qualification_certificates' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.company_registration' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'terms_accepted' => 'required|accepted',
            'privacy_accepted' => 'required|accepted'
        ]);

        try {
            DB::beginTransaction();

            $artisan = Artisan::create(array_merge(
                $validated,
                ['user_id' => auth()->id()],
                ['documents' => [
                    'decennial_insurance' => $request->file('documents.decennial_insurance')->store('artisan-documents', 'private'),
                    'professional_insurance' => $request->file('documents.professional_insurance')->store('artisan-documents', 'private'),
                    'qualification_certificates' => $request->hasFile('documents.qualification_certificates') 
                        ? $request->file('documents.qualification_certificates')->store('artisan-documents', 'private')
                        : null,
                    'company_registration' => $request->file('documents.company_registration')->store('artisan-documents', 'private'),
                ]]
            ));

            DB::commit();

            return redirect()->route('artisan.dashboard')
                ->with('success', 'Profil complété avec succès ! Nous examinerons vos documents sous 24-48h.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error completing artisan profile', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du profil.');
        }
    }
}
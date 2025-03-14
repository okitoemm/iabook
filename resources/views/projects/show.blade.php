<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- En-tête du projet -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $project->title }}</h1>
                            <p class="text-gray-600">Publié {{ $project->created_at->diffForHumans() }}</p>
                        </div>
                        @if($project->urgent)
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full">Urgent</span>
                        @endif
                    </div>

                    <!-- Photos du projet -->
                    @if($project->photos && json_decode($project->photos))
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-3">Photos</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach(json_decode($project->photos) as $photo)
                                    <div class="relative aspect-w-16 aspect-h-9">
                                        <img src="{{ $photo }}" 
                                             alt="Photo du projet"
                                             class="object-cover rounded-lg w-full h-full">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Détails du projet -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold mb-3">Description</h2>
                            <p class="text-gray-700">{{ $project->description }}</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h2 class="text-lg font-semibold mb-2">Informations</h2>
                                <dl class="grid grid-cols-2 gap-2">
                                    <dt class="text-gray-600">Catégorie</dt>
                                    <dd>{{ ucfirst($project->category) }}</dd>
                                    
                                    <dt class="text-gray-600">Budget</dt>
                                    <dd>{{ $project->budget }}€ ({{ $project->budget_type }})</dd>
                                    
                                    <dt class="text-gray-600">Localisation</dt>
                                    <dd>{{ $project->city }} ({{ $project->postal_code }})</dd>
                                </dl>
                            </div>

                            <!-- Disponibilités -->
                            @if($project->availability_days)
                                <div>
                                    <h3 class="font-semibold">Disponibilités</h3>
                                    <p>
                                        Jours : {{ implode(', ', json_decode($project->availability_days)) }}<br>
                                        Heures : {{ implode(', ', json_decode($project->availability_hours)) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4" x-data="{ 
                        showContactModal: false,
                        messageContent: '',
                        selectedTemplate: '',
                        messageTemplates: [
                            {
                                title: 'Introduction Professionnelle',
                                content: `Bonjour,\n\nJe suis intéressé par votre projet de ${@json($project->title)}. En tant qu'artisan spécialisé en ${auth()->user()->artisan->specialty}, j'ai réalisé de nombreux projets similaires.\n\nJe souhaiterais en discuter plus en détail avec vous.\n\nCordialement,\n${auth()->user()->name}`
                            },
                            {
                                title: 'Question sur le planning',
                                content: `Bonjour,\n\nVotre projet m'intéresse. Avant de vous faire une proposition, j'aurais besoin de quelques précisions sur vos disponibilités.\n\nQuand souhaiteriez-vous démarrer les travaux ?\n\nCordialement,\n${auth()->user()->name}`
                            },
                            {
                                title: 'Demande de détails',
                                content: `Bonjour,\n\nJe suis intéressé par votre projet. Pour vous faire une proposition précise, j'aurais besoin de quelques informations supplémentaires :\n- Avez-vous des contraintes particulières ?\n- Y a-t-il des détails spécifiques à prendre en compte ?\n\nCordialement,\n${auth()->user()->name}`
                            }
                        ],
                        async sendMessage() {
                            try {
                                const response = await fetch('{{ route("projects.contact", ["project" => $project->id]) }}', {  // Changé la route
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        message: this.messageContent
                                    })
                                });

                                const data = await response.json();
                                
                                if (data.success) {
                                    this.showContactModal = false;
                                    window.dispatchEvent(new CustomEvent('notify', {
                                        detail: {
                                            type: 'success',
                                            message: 'Message envoyé avec succès'
                                        }
                                    }));
                                }
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        }
                    }">
                        <a href="{{ route('projects.available') }}" 
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Retour aux projets
                        </a>
                        @if(auth()->user()->role === 'artisan')
                            <button @click="showContactModal = true"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Contacter le client
                            </button>
                        @endif

                        @include('projects.partials._contact-modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

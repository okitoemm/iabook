<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg">
                <!-- Progress bar -->
                <div class="border-b px-4 py-3">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-900">Complétez votre profil d'artisan</h2>
                        <div class="flex space-x-2">
                            <span :class="{ 'bg-indigo-600': step >= 1, 'bg-gray-200': step < 1 }" class="w-3 h-3 rounded-full"></span>
                            <span :class="{ 'bg-indigo-600': step >= 2, 'bg-gray-200': step < 2 }" class="w-3 h-3 rounded-full"></span>
                            <span :class="{ 'bg-indigo-600': step >= 3, 'bg-gray-200': step < 3 }" class="w-3 h-3 rounded-full"></span>
                            <span :class="{ 'bg-indigo-600': step >= 4, 'bg-gray-200': step < 4 }" class="w-3 h-3 rounded-full"></span>
                        </div>
                    </div>
                </div>

                <div x-data="{ 
                    step: 1,
                    totalSteps: 4,
                    formData: {
                        business_name: '',
                        siret: '',
                        specialty: '',
                        description: '',
                        experience_years: 0,
                        hourly_rate: 0,
                        service_area: '',
                        payment_methods: [],
                        legal_documents: {
                            decennial_insurance: null,
                            professional_insurance: null,
                            qualification_certificates: null,
                            company_registration: null
                        },
                        terms_accepted: false,
                        privacy_accepted: false
                    },
                    showStep(stepNumber) {
                        return this.step === stepNumber;
                    }
                }" class="p-6">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <!-- Étape 1 -->
                        <div x-show="showStep(1)" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                                <input type="text" x-model="formData.business_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numéro SIRET</label>
                                <input type="text" x-model="formData.siret" maxlength="14" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Spécialité principale</label>
                                <select x-model="formData.specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Sélectionnez une spécialité</option>
                                    @foreach($specialties as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Étape 2 -->
                        <div x-show="showStep(2)" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description de votre activité</label>
                                <textarea x-model="formData.description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                                <p class="mt-2 text-sm text-gray-500">Minimum 100 caractères</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Années d'expérience</label>
                                    <input type="number" x-model="formData.experience_years" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Taux horaire (€)</label>
                                    <input type="number" x-model="formData.hourly_rate" min="0" step="0.5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3 -->
                        <div x-show="showStep(3)" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Zone d'intervention</label>
                                <input type="text" x-model="formData.service_area" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Moyens de paiement acceptés</label>
                                <div class="space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" x-model="formData.payment_methods" value="cb" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Carte bancaire</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" x-model="formData.payment_methods" value="especes" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Espèces</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" x-model="formData.payment_methods" value="cheque" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Chèque</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Nouvelle Étape 4: Documents légaux et conformité -->
                        <div x-show="showStep(4)" class="space-y-6">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Ces documents sont nécessaires pour vérifier votre statut d'artisan. Ils seront traités de manière confidentielle.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Assurance décennale -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Assurance décennale</label>
                                <div class="flex items-center space-x-2">
                                    <input type="file" 
                                        @change="formData.legal_documents.decennial_insurance = $event.target.files[0]"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100"
                                        required>
                                </div>
                                <p class="text-xs text-gray-500">Format PDF, JPG - Max 5MB</p>
                            </div>

                            <!-- Assurance responsabilité civile professionnelle -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Assurance responsabilité civile professionnelle</label>
                                <input type="file" 
                                    @change="formData.legal_documents.professional_insurance = $event.target.files[0]"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100"
                                    required>
                            </div>

                            <!-- Certificats de qualification -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Certificats de qualification (RGE, Qualibat, etc.)</label>
                                <input type="file" 
                                    @change="formData.legal_documents.qualification_certificates = $event.target.files[0]"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100">
                            </div>

                            <!-- Kbis ou inscription Chambre des Métiers -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Extrait Kbis ou inscription Chambre des Métiers</label>
                                <input type="file" 
                                    @change="formData.legal_documents.company_registration = $event.target.files[0]"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100"
                                    required>
                            </div>

                            <!-- Conditions et politique -->
                            <div class="space-y-4 mt-6">
                                <div class="flex items-start">
                                    <input type="checkbox" 
                                        x-model="formData.terms_accepted"
                                        class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <label class="ml-2 block text-sm text-gray-700">
                                        J'accepte les <a href="{{ route('legal.terms') }}" target="_blank" class="text-indigo-600 hover:text-indigo-700">conditions générales</a> et certifie que les documents fournis sont authentiques
                                    </label>
                                </div>

                                <div class="flex items-start">
                                    <input type="checkbox" 
                                        x-model="formData.privacy_accepted"
                                        class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <label class="ml-2 block text-sm text-gray-700">
                                        J'accepte que mes informations soient traitées conformément à la <a href="{{ route('legal.privacy') }}" target="_blank" class="text-indigo-600 hover:text-indigo-700">politique de confidentialité</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between mt-8">
                            <button 
                                type="button"
                                x-show="step > 1"
                                @click="step--"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                            >
                                Précédent
                            </button>

                            <button 
                                type="button"
                                x-show="step < 4"
                                @click="step++"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                            >
                                Suivant
                            </button>

                            <button 
                                type="submit"
                                x-show="step === 4"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                            >
                                Terminer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function completionForm() {
            return {
                step: 1,
                totalSteps: 4,
                formData: {
                    business_name: '',
                    siret: '',
                    specialty: '',
                    description: '',
                    experience_years: 0,
                    hourly_rate: 0,
                    service_area: '',
                    payment_methods: [],
                    legal_documents: {
                        decennial_insurance: null,
                        professional_insurance: null,
                        qualification_certificates: null,
                        company_registration: null
                    },
                    terms_accepted: false,
                    privacy_accepted: false
                },
                
                async submitForm() {
                    try {
                        const formData = new FormData();
                        
                        // Ajout des champs de base
                        Object.keys(this.formData).forEach(key => {
                            if (key !== 'legal_documents') {
                                formData.append(key, 
                                    Array.isArray(this.formData[key]) 
                                        ? JSON.stringify(this.formData[key])
                                        : this.formData[key]
                                );
                            }
                        });

                        // Ajout des documents
                        Object.keys(this.formData.legal_documents).forEach(docKey => {
                            if (this.formData.legal_documents[docKey]) {
                                formData.append(`documents[${docKey}]`, this.formData.legal_documents[docKey]);
                            }
                        });

                        const response = await fetch('{{ route("artisan.complete-profile") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Afficher un message de succès
                            this.$dispatch('notify', {
                                type: 'success',
                                message: data.message
                            });

                            // Rediriger vers la page des projets disponibles
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.$dispatch('notify', {
                            type: 'error',
                            message: error.message || 'Une erreur est survenue'
                        });
                    }
                }
            }
        }
    </script>
    @endpush
</x-app-layout>

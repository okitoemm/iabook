<x-app-layout>
    <div x-data="completeProfile" class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex justify-between">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                :class="currentStep >= index ? 'bg-indigo-600 text-white' : 'bg-gray-200'">
                                <span x-text="index + 1"></span>
                            </div>
                            <div x-show="index < steps.length - 1" class="h-1 w-16 mx-2"
                                :class="currentStep > index ? 'bg-indigo-600' : 'bg-gray-200'"></div>
                        </div>
                    </template>
                </div>
            </div>

            <form @submit.prevent="submitForm" class="bg-white shadow rounded-lg">
                <!-- Step 1: Personal Info -->
                <div x-show="currentStep === 0" class="p-6 space-y-6">
                    <h2 class="text-lg font-medium">Informations personnelles</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prénom et Nom</label>
                            <input type="text" x-model="formData.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Step 2: Contact Info -->
                <div x-show="currentStep === 1" class="p-6 space-y-6">
                    <h2 class="text-lg font-medium">Coordonnées</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" x-model="formData.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" x-model="formData.address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Code postal</label>
                                <input type="text" x-model="formData.postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ville</label>
                                <input type="text" x-model="formData.city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Preferences -->
                <div x-show="currentStep === 2" class="p-6 space-y-6">
                    <h2 class="text-lg font-medium">Préférences</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Méthode de contact préférée</label>
                            <select x-model="formData.preferred_contact_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="email">Email</option>
                                <option value="phone">Téléphone</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" x-model="formData.notify_new_quotes" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">
                                M'informer des nouvelles propositions par email
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="px-6 py-4 bg-gray-50 flex justify-between rounded-b-lg">
                    <button type="button" 
                        x-show="currentStep > 0"
                        @click="previousStep"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Précédent
                    </button>

                    <button type="button" 
                        x-show="currentStep < steps.length - 1"
                        @click="nextStep"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Suivant
                    </button>

                    <button type="submit"
                        x-show="currentStep === steps.length - 1"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Terminer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function completeProfile() {
        return {
            currentStep: 0,
            steps: ['personal', 'contact', 'preferences'],
            formData: {
                name: '{{ auth()->user()->name }}',
                phone: '',
                address: '',
                postal_code: '',
                city: '',
                preferred_contact_method: 'email',
                notify_new_quotes: true
            },

            nextStep() {
                if (this.validateCurrentStep()) {
                    this.currentStep++;
                }
            },

            previousStep() {
                this.currentStep--;
            },

            validateCurrentStep() {
                switch(this.currentStep) {
                    case 0:
                        return this.formData.name.length >= 2;
                    case 1:
                        return this.formData.phone && 
                               this.formData.address && 
                               this.formData.postal_code && 
                               this.formData.city;
                    default:
                        return true;
                }
            },

            async submitForm() {
                try {
                    const response = await fetch('{{ route("client.complete-profile") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(this.formData)
                    });

                    if (response.ok) {
                        window.location.href = '{{ route("client.dashboard") }}';
                    } else {
                        const data = await response.json();
                        alert(data.message || 'Une erreur est survenue');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                }
            }
        }
    }
    </script>
</x-app-layout>

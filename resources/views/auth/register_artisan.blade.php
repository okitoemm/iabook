@extends('layouts.app')

@section('title', 'Inscription Artisan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Artisan Registration</h1>

        <form method="POST" action="{{ route('register.artisan.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Business Name</label>
                <input type="text" name="business_name" value="{{ old('business_name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">SIRET</label>
                <div class="relative" x-data="{ siret: '{{ old('siret', '') }}' }">
                    <input 
                        type="text" 
                        name="siret" 
                        x-model="siret"
                        @input="siret = $event.target.value.replace(/[^0-9]/g, '').substring(0, 14)"
                        maxlength="14"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        :class="{ 
                            'border-red-300': siret.length > 0 && siret.length !== 14,
                            'border-green-300': siret.length === 14
                        }"
                        placeholder="12345678901234"
                    >
                    <div class="mt-1 flex justify-between text-sm">
                        <span x-show="siret.length > 0" 
                            :class="{
                                'text-red-600': siret.length !== 14,
                                'text-green-600': siret.length === 14
                            }">
                            <span x-text="siret.length"></span>/14 chiffres
                        </span>
                        <template x-if="siret.length > 0 && siret.length !== 14">
                            <span class="text-red-600" x-text="`Il manque ${14 - siret.length} chiffre${14 - siret.length > 1 ? 's' : ''}`"></span>
                        </template>
                        <template x-if="siret.length === 14">
                            <span class="text-green-600">✓ Format valide</span>
                        </template>
                    </div>

                    <!-- Guide SIRET -->
                    <div class="mt-2 text-sm text-gray-500 bg-gray-50 p-2 rounded">
                        <p>Le numéro SIRET est composé de 14 chiffres :</p>
                        <ul class="list-disc list-inside mt-1">
                            <li>9 chiffres pour le SIREN</li>
                            <li>5 chiffres pour le NIC</li>
                        </ul>
                    </div>

                    @error('siret')
                        <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Specialty</label>
                <input type="text" name="specialty" value="{{ old('specialty') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Experience (years)</label>
                <input type="number" name="experience_years" value="{{ old('experience_years') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hourly Rate (€)</label>
                <input type="number" name="hourly_rate" value="{{ old('hourly_rate') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Service Area</label>
                <input type="text" name="service_area" value="{{ old('service_area') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Description de votre activité</label>
                
                <!-- Conteneur de la description avec compteur -->
                <div x-data="{ 
                    charCount: 0,
                    minChars: 100,
                    content: '',
                    init() {
                        this.content = this.$refs.description.value;
                        this.charCount = this.content.length;
                        this.updateCounter();
                    },
                    updateCounter() {
                        this.charCount = this.content.length;
                    }
                }">
                    <div class="relative">
                        <textarea
                            x-ref="description"
                            x-model="content"
                            @input="updateCounter"
                            name="description"
                            rows="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-20"
                            :class="{
                                'border-red-300 focus:border-red-500 focus:ring-red-500': charCount > 0 && charCount < minChars,
                                'border-green-300 focus:border-green-500 focus:ring-green-500': charCount >= minChars
                            }"
                        >{{ old('description') }}</textarea>

                        <!-- Compteur flottant -->
                        <div class="absolute bottom-3 right-3 text-sm font-medium rounded-full px-2 py-1"
                            :class="{
                                'text-red-600': charCount > 0 && charCount < minChars,
                                'text-green-600': charCount >= minChars,
                                'text-gray-400': charCount === 0
                            }">
                            <span x-text="charCount"></span>/<span x-text="minChars"></span>
                        </div>
                    </div>

                    <!-- Barre de progression -->
                    <div class="mt-2 h-1 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-300 bg-indigo-600 rounded-full"
                            :style="{ width: `${Math.min((charCount / minChars) * 100, 100)}%` }"
                            :class="{ 'bg-red-500': charCount > 0 && charCount < minChars, 'bg-green-500': charCount >= minChars }">
                        </div>
                    </div>

                    <!-- Message d'aide -->
                    <div class="mt-2 text-sm"
                        :class="{
                            'text-red-600': charCount > 0 && charCount < minChars,
                            'text-green-600': charCount >= minChars,
                            'text-gray-500': charCount === 0
                        }">
                        <template x-if="charCount === 0">
                            <span>Minimum requis : 100 caractères</span>
                        </template>
                        <template x-if="charCount > 0 && charCount < minChars">
                            <span x-text="`Encore ${minChars - charCount} caractères requis`"></span>
                        </template>
                        <template x-if="charCount >= minChars">
                            <span>✓ Description suffisamment détaillée</span>
                        </template>
                    </div>
                </div>

                <!-- Guide de rédaction -->
                <div class="mt-2 bg-blue-50 p-3 rounded-md">
                    <h4 class="text-sm font-medium text-blue-800">Guide pour une bonne description :</h4>
                    <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                        <li>Présentez vos domaines d'expertise</li>
                        <li>Mentionnez vos années d'expérience</li>
                        <li>Listez vos certifications et qualifications</li>
                        <li>Décrivez vos réalisations marquantes</li>
                        <li>Indiquez vos spécialités techniques</li>
                    </ul>
                </div>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <div class="mt-1 relative" x-data="{ 
                    showPassword: false,
                    password: '',
                    validLength: false,
                    hasUppercase: false,
                    hasLowercase: false,
                    hasNumber: false,
                    checkPassword() {
                        this.validLength = this.password.length >= 8;
                        this.hasUppercase = /[A-Z]/.test(this.password);
                        this.hasLowercase = /[a-z]/.test(this.password);
                        this.hasNumber = /[0-9]/.test(this.password);
                    }
                }">
                    <input 
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        x-model="password"
                        @input="checkPassword"
                        required
                        class="block w-full rounded-md border-gray-300 pr-10"
                        :class="{
                            'border-red-300 focus:border-red-500 focus:ring-red-500': password.length > 0 && (!validLength || !hasUppercase || !hasLowercase || !hasNumber),
                            'border-green-300 focus:border-green-500 focus:ring-green-500': password.length > 0 && validLength && hasUppercase && hasLowercase && hasNumber
                        }"
                    >
                    <button 
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 px-3 flex items-center"
                    >
                        <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                    <div class="mt-2 text-sm space-y-1">
                        <p class="font-medium text-gray-700">Exigences du mot de passe :</p>
                        <div :class="validLength ? 'text-green-600' : 'text-red-600'">
                            <span x-text="validLength ? '✓' : '○'"></span> Au moins 8 caractères
                        </div>
                        <div :class="hasUppercase ? 'text-green-600' : 'text-red-600'">
                            <span x-text="hasUppercase ? '✓' : '○'"></span> Au moins une majuscule
                        </div>
                        <div :class="hasLowercase ? 'text-green-600' : 'text-red-600'">
                            <span x-text="hasLowercase ? '✓' : '○'"></span> Au moins une minuscule
                        </div>
                        <div :class="hasNumber ? 'text-green-600' : 'text-red-600'">
                            <span x-text="hasNumber ? '✓' : '○'"></span> Au moins un chiffre
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <div class="mt-1 relative" x-data="{ showPassword: false }">
                    <input 
                        :type="showPassword ? 'text' : 'password'"
                        name="password_confirmation" 
                        required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10 @error('password_confirmation') border-red-300 @enderror"
                    >
                    <button 
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 px-3 flex items-center"
                    >
                        <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <div class="flex items-center">
                    <input type="checkbox" name="terms" id="terms" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        J'accepte les <a href="{{ route('terms') }}" target="_blank" class="text-indigo-600 hover:text-indigo-500">conditions générales d'utilisation</a>
                    </label>
                </div>
                @error('terms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
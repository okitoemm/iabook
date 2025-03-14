@extends('layouts.app')

@section('content')
<div x-data="projectForm()" class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps - Mobile Optimized -->
        <div class="max-w-3xl mx-auto mb-8">
            <!-- Step indicator for mobile -->
            <div class="md:hidden mb-4">
                <div class="text-center">
                    <span class="text-lg font-medium text-indigo-600" x-text="steps[currentStep]"></span>
                    <span class="text-gray-500"> - Étape <span x-text="currentStep + 1"></span>/<span x-text="steps.length"></span></span>
                </div>
                <div class="mt-2 h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full transition-all duration-500"
                        :style="`width: ${(currentStep + 1) / steps.length * 100}%`"></div>
                </div>
            </div>

            <!-- Desktop steps - hide on mobile -->
            <div class="hidden md:block">
                <div class="flex justify-between">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex items-center">
                            <div :class="{
                                'bg-indigo-600 text-white': currentStep >= index,
                                'bg-gray-200 text-gray-600': currentStep < index
                            }" class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300">
                                <span x-text="index + 1"></span>
                            </div>
                            <div x-show="index < steps.length - 1" class="h-1 w-16 mx-2" :class="currentStep > index ? 'bg-indigo-600' : 'bg-gray-200'"></div>
                        </div>
                    </template>
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <span>Informations</span>
                    <span>Médias</span>
                    <span>Vérification</span>
                    <span>Disponibilités</span>
                    <span>Prévisualisation</span>
                </div>
            </div>
        </div>

        <!-- Form Container - Mobile Optimized -->
        <div class="max-w-3xl mx-auto">
            <form id="projectForm" @submit.prevent="previewProject" 
                class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 mx-auto w-full">
                
                <!-- Common mobile adjustments for all steps -->
                <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                    <!-- Each step container gets mobile padding adjustments -->
                    <div x-show="currentStep === 0" class="space-y-4" x-transition>
                        <div class="border-b pb-4">
                            <h2 class="text-xl font-semibold">Informations du projet</h2>
                            <p class="text-gray-500 text-sm">Décrivez votre projet en détail</p>
                        </div>

                        <div class="space-y-4">
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">
                                    Titre du projet
                                </label>
                                <input type="text" x-model="formData.title" 
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                    @input="validateField('title')"
                                    :class="{'border-red-300': errors.title}">
                                <p x-show="errors.title" x-text="errors.title" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Description détaillée -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">
                                    Description détaillée du projet
                                </label>
                                <div class="mt-1 relative">
                                    <textarea 
                                        x-model="formData.description" 
                                        rows="6"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                        placeholder="Décrivez votre projet en détail : nature des travaux, matériaux souhaités, contraintes particulières..."
                                        @input="validateField('description')"></textarea>
                                    <div class="absolute bottom-2 right-2 text-sm text-gray-500" x-show="formData.description">
                                        <span x-text="formData.description.length"></span>/1000
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Minimum 100 caractères recommandé pour une meilleure compréhension</p>
                                <p x-show="errors.description" x-text="errors.description" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Adresse complète -->
                            <div class="space-y-4 border-t pt-4">
                                <h3 class="text-lg font-medium text-gray-900">Localisation du projet</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="group">
                                        <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                            Adresse
                                        </label>
                                        <input type="text" 
                                            x-model="formData.address" 
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Numéro et nom de rue"
                                            @input="validateField('address')">
                                    </div>

                                    <div class="group">
                                        <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                            Complément d'adresse
                                        </label>
                                        <input type="text" 
                                            x-model="formData.address_complement" 
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Bâtiment, étage, etc.">
                                    </div>

                                    <div class="group">
                                        <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                            Code postal
                                        </label>
                                        <input type="text" 
                                            x-model="formData.postal_code" 
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            @input="validateField('postal_code')">
                                    </div>

                                    <div class="group">
                                        <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                            Ville
                                        </label>
                                        <input type="text" 
                                            x-model="formData.city" 
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            @input="validateField('city')">
                                    </div>
                                </div>

                                <!-- Instructions d'accès -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                        Instructions d'accès (facultatif)
                                    </label>
                                    <textarea 
                                        x-model="formData.access_instructions" 
                                        rows="2"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Code d'accès, parking, particularités..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Budget Section -->
                        <div class="space-y-4 border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Budget & Durée</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                        Type de budget
                                    </label>
                                    <select x-model="formData.budget_type" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="fixed">Budget total fixe</option>
                                        <option value="hourly">Taux horaire</option>
                                    </select>
                                </div>

                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                        <span x-text="formData.budget_type === 'hourly' ? 'Taux horaire maximum (€/h)' : 'Budget total (€)'"></span>
                                    </label>
                                    <input type="number" 
                                        x-model="formData.budget" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        :placeholder="formData.budget_type === 'hourly' ? '50' : '1000'"
                                        min="0"
                                        step="0.01">
                                </div>

                                <div class="group" x-show="formData.budget_type === 'hourly'">
                                    <label class="block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                        Nombre d'heures estimé
                                    </label>
                                    <input type="number" 
                                        x-model="formData.estimated_hours" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="8"
                                        min="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Upload - Mobile Optimized -->
                    <div x-show="currentStep === 1" x-transition>
                        <div class="border-b pb-4">
                            <h2 class="text-xl font-semibold">Photos et Vidéo</h2>
                            <p class="text-gray-500 text-sm">Ajoutez des visuels pour illustrer votre projet</p>
                        </div>

                        <!-- Photos Upload -->
                        <div class="space-y-4">
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700">Photos du projet</label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors"
                                    @dragover.prevent="dragOver"
                                    @dragleave.prevent="dragLeave"
                                    @drop.prevent="handleDrop">
                                    
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Télécharger des photos</span>
                                                <input type="file" class="sr-only" multiple accept="image/*" @change="handlePhotosSelect">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Photos - Mobile Grid -->
                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-4" x-show="formData.photos.length">
                                    <template x-for="(photo, index) in formData.photos" :key="index">
                                        <div class="relative group">
                                            <img :src="photo.preview" class="h-24 w-24 object-cover rounded-lg">
                                            <button @click="removePhoto(index)" 
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Video Upload -->
                            <div class="group mt-6 space-y-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Vidéo de présentation (facultatif)
                                </label>
                                <div class="mt-2">
                                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors">
                                        <div class="space-y-2 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                    <span>Ajouter une vidéo</span>
                                                    <input type="file" 
                                                        class="sr-only" 
                                                        accept="video/*"
                                                        @change="handleVideoSelect">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">MP4 uniquement, max 1 minute</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Video Preview -->
                                <div x-show="formData.video" class="mt-4">
                                    <div class="relative rounded-lg overflow-hidden">
                                        <video :src="formData.video.preview" controls class="w-full"></video>
                                        <button @click="removeVideo" 
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500" x-text="getDuration()"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile-friendly verification method selection -->
                    <div x-show="currentStep === 2" x-transition>
                        <div class="border-b pb-4">
                            <h2 class="text-xl font-semibold">Vérification d'identité</h2>
                            <p class="text-gray-500 text-sm">Pour garantir la sécurité des artisans</p>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v5a1 1 0 102 0V7zm-1 9a1 1 0 100-2 1 1 0 000 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Pourquoi vérifier ?</h3>
                                        <p class="mt-2 text-sm text-yellow-700">
                                            La vérification permet de rassurer les artisans et garantir le sérieux de votre projet.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <!-- Méthode de vérification -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-medium text-gray-700">Choisissez votre méthode de vérification</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <template x-for="method in verificationMethods" :key="method.id">
                                            <div class="relative">
                                                <input type="radio" :id="method.id" name="verification_method" 
                                                    :value="method.id" x-model="formData.verification_method"
                                                    class="peer sr-only">
                                                <label :for="method.id" 
                                                    class="flex flex-col p-4 bg-white border rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-indigo-600 peer-checked:ring-1 peer-checked:ring-indigo-600">
                                                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 rounded-full bg-indigo-100">
                                                        <template x-if="method.icon">
                                                            <div x-html="method.icon" class="w-6 h-6 text-indigo-600"></div>
                                                        </template>
                                                    </div>
                                                    <div class="text-center">
                                                        <span x-text="method.name" class="block font-medium"></span>
                                                        <span x-text="method.description" class="block text-sm text-gray-500"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile-optimized availability selection -->
                    <div x-show="currentStep === 3" x-transition>
                        <div class="border-b pb-4">
                            <h2 class="text-xl font-semibold">Vos disponibilités</h2>
                            <p class="text-gray-500 text-sm">Pour faciliter les visites et les contacts</p>
                        </div>

                        <div class="space-y-6">
                            <!-- Urgent ou non -->
                            <div class="flex items-center space-x-3 p-4 bg-white rounded-lg border hover:bg-gray-50">
                                <input type="checkbox" id="urgent" x-model="formData.urgent"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="urgent" class="flex-1">
                                    <span class="block font-medium text-gray-900">Projet urgent</span>
                                    <span class="block text-sm text-gray-500">Intervention nécessaire sous 48h</span>
                                </label>
                            </div>

                            <!-- Préférence de contact -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-700">Comment souhaitez-vous être contacté ?</label>
                                <div class="space-y-2">
                                    <template x-for="pref in contactPreferences" :key="pref.value">
                                        <div class="flex items-center">
                                            <input type="radio" :id="pref.value" name="contact_preference" 
                                                :value="pref.value" x-model="formData.contact_preference"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <label :for="pref.value" class="ml-3">
                                                <span x-text="pref.label" class="block text-sm font-medium text-gray-700"></span>
                                            </label>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Disponibilités par jour -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-700">Vos créneaux de disponibilité</label>
                                <div class="grid gap-4">
                                    <template x-for="day in availableDays" :key="day.value">
                                        <div class="flex items-center space-x-4 p-3 bg-white rounded-lg border hover:bg-gray-50">
                                            <input type="checkbox" :id="day.value" 
                                                x-model="formData.availability_days" 
                                                :value="day.value"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <div class="flex-1">
                                                <label :for="day.value" class="flex items-center justify-between">
                                                    <span x-text="day.label" class="font-medium"></span>
                                                    <select x-model="formData.availability_hours[day.value]" 
                                                        class="ml-4 rounded-md border-gray-300 text-sm"
                                                        :disabled="!formData.availability_days.includes(day.value)">
                                                        <option value="">Choisir horaire</option>
                                                        <option value="morning">Matin (8h-12h)</option>
                                                        <option value="afternoon">Après-midi (14h-18h)</option>
                                                        <option value="evening">Soir (18h-20h)</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview - Mobile Optimized -->
                    <div x-show="currentStep === 4" x-transition>
                        <div class="border-b pb-4 mb-6">
                            <h2 class="text-xl font-semibold">Prévisualisation de votre projet</h2>
                            <p class="text-gray-500 text-sm">Vérifiez tous les détails avant publication</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6">
                            <!-- En-tête du projet -->
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold" x-text="formData.title"></h3>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="flex items-center text-gray-600">
                                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            <span x-text="formData.location"></span>
                                        </span>
                                        <span class="flex items-center text-gray-600">
                                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span x-text="formData.deadline"></span>
                                        </span>
                                        <span x-show="formData.urgent" 
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Urgent (48h)
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-indigo-600" x-text="`${formData.budget}€`"></span>
                                    <p class="text-sm text-gray-500">Budget estimé</p>
                                </div>
                            </div>

                            <!-- Détails du projet -->
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold mb-2">Description</h4>
                                <p class="text-gray-700 whitespace-pre-line" x-text="formData.description"></p>
                            </div>

                            <!-- Galerie photos -->
                            <div class="mt-6" x-show="formData.photos.length">
                                <h4 class="text-lg font-semibold mb-3">Photos</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <template x-for="photo in formData.photos" :key="photo.preview">
                                        <div class="relative group aspect-w-16 aspect-h-9">
                                            <img :src="photo.preview" class="rounded-lg object-cover w-full h-full">
                                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                                <button @click="openPhotoViewer(photo)" class="text-white hover:text-gray-200">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Vidéo -->
                            <div class="mt-6" x-show="formData.video">
                                <h4 class="text-lg font-semibold mb-3">Vidéo de présentation</h4>
                                <div class="aspect-w-16 aspect-h-9">
                                    <video controls class="rounded-lg w-full" :src="formData.video.preview"></video>
                                </div>
                            </div>

                            <!-- Vérification et Contact -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-green-800 mb-2">Vérification</h4>
                                    <p class="text-green-700" x-text="getVerificationMethodLabel()"></p>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-blue-800 mb-2">Préférence de contact</h4>
                                    <p class="text-blue-700" x-text="getContactPreferenceLabel()"></p>
                                </div>
                            </div>

                            <!-- Disponibilités -->
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold mb-3">Disponibilités pour visite</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    <template x-for="day in getSelectedDays()" :key="day.value">
                                        <div class="bg-gray-100 p-3 rounded-lg">
                                            <span class="font-medium" x-text="day.label"></span>
                                            <p class="text-sm text-gray-600" x-text="getTimeSlotLabel(formData.availability_hours[day.value])"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Adresse détaillée -->
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold mb-2">Localisation</h4>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-gray-900" x-text="formData.address"></p>
                                    <p class="text-gray-700" x-show="formData.address_complement" x-text="formData.address_complement"></p>
                                    <p class="text-gray-900" x-text="`${formData.postal_code} ${formData.city}`"></p>
                                    <p class="mt-2 text-gray-600 italic" x-show="formData.access_instructions" x-text="formData.access_instructions"></p>
                                </div>
                            </div>

                            <!-- Description détaillée -->
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold mb-2">Description détaillée</h4>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-gray-700 whitespace-pre-line" x-text="formData.description"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Action finale -->
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" @click="previousStep"
                                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Modifier
                            </button>
                            <button type="submit" @click="publishProject"
                                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Publier le projet
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons - Mobile Sticky Footer -->
                <div class="sticky bottom-0 left-0 right-0 px-4 py-3 sm:px-6 sm:py-4 bg-gray-50 border-t flex justify-between items-center">
                    <button type="button" 
                        x-show="currentStep > 0"
                        @click="previousStep"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Retour
                    </button>
                    
                    <button type="button" 
                        x-show="currentStep < steps.length - 1"
                        @click="nextStep"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
                        Suivant
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <button type="submit" 
                        x-show="currentStep === steps.length - 1"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Publier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function projectForm() {
    return {
        steps: ['info', 'media', 'verification', 'availability', 'preview'],
        currentStep: 0,
        formData: {
            title: '',
            description: '',
            category: '',
            budget: '',
            deadline: '',
            location: '',
            photos: [],
            video: null,
            verification_method: '',
            urgent: false,
            contact_preference: '',
            availability_days: [],
            availability_hours: {},
            address: '',
            address_complement: '',
            postal_code: '',
            city: '',
            access_instructions: '',
            budget_type: 'fixed',
            estimated_hours: '',
        },
        errors: {},
        
        validateField(field) {
            this.errors[field] = '';
            switch(field) {
                case 'description':
                    if (this.formData.description.length < 100) {
                        this.errors[field] = 'La description doit faire au moins 100 caractères';
                    }
                    break;
                case 'address':
                    if (!this.formData.address) {
                        this.errors[field] = 'L\'adresse est requise';
                    }
                    break;
                case 'postal_code':
                    if (!/^\d{5}$/.test(this.formData.postal_code)) {
                        this.errors[field] = 'Code postal invalide';
                    }
                    break;
                case 'city':
                    if (!this.formData.city) {
                        this.errors[field] = 'La ville est requise';
                    }
                    break;
            }
        },

        handlePhotosSelect(e) {
            const files = Array.from(e.target.files);
            this.processFiles(files);
        },

        handleDrop(e) {
            const files = Array.from(e.dataTransfer.files);
            this.processFiles(files);
        },

        processFiles(files) {
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.formData.photos.push({
                            file: file,
                            preview: e.target.result
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
        },

        removePhoto(index) {
            this.formData.photos.splice(index, 1);
        },

        handleVideoSelect(e) {
            const file = e.target.files[0];
            if (file) {
                // Vérifier la durée de la vidéo
                const video = document.createElement('video');
                video.preload = 'metadata';

                video.onloadedmetadata = () => {
                    window.URL.revokeObjectURL(video.src);
                    if (video.duration > 60) {
                        alert('La vidéo ne doit pas dépasser 1 minute');
                        e.target.value = '';
                        return;
                    }

                    this.formData.video = {
                        file: file,
                        preview: URL.createObjectURL(file),
                        duration: video.duration
                    };
                };

                video.src = URL.createObjectURL(file);
            }
        },

        removeVideo() {
            this.formData.video = null;
        },

        getDuration() {
            if (!this.formData.video) return '';
            const seconds = Math.round(this.formData.video.duration);
            return `Durée: ${Math.floor(seconds / 60)}:${(seconds % 60).toString().padStart(2, '0')}`;
        },

        // Ajout de méthodes pour la gestion du mobile
        isMobile() {
            return window.innerWidth < 640;
        },

        // Amélioration de la navigation pour le mobile
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;
                if (this.isMobile()) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        },

        previousStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
                if (this.isMobile()) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        },

        previewProject() {
            // Logic to submit the form
            console.log('Submitting project:', this.formData);
        },

        verificationMethods: [
            {
                id: 'phone',
                name: 'Téléphone',
                description: 'Vérification rapide par SMS',
                icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>'
            },
            {
                id: 'id',
                name: 'Pièce d\'identité',
                description: 'Photo de votre CNI ou passeport',
                icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>'
            },
            {
                id: 'address',
                name: 'Justificatif domicile',
                description: 'Facture récente à votre nom',
                icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'
            }
        ],

        availableDays: [
            { value: 'monday', label: 'Lundi' },
            { value: 'tuesday', label: 'Mardi' },
            { value: 'wednesday', label: 'Mercredi' },
            { value: 'thursday', label: 'Jeudi' },
            { value: 'friday', label: 'Vendredi' },
            { value: 'saturday', label: 'Samedi' },
            { value: 'sunday', label: 'Dimanche' }
        ],

        contactPreferences: [
            { value: 'phone', label: 'Par téléphone uniquement' },
            { value: 'email', label: 'Par email uniquement' },
            { value: 'both', label: 'Téléphone et email' }
        ],

        getVerificationMethodLabel() {
            const method = this.verificationMethods.find(m => m.id === this.formData.verification_method);
            return method ? `${method.name} - ${method.description}` : '';
        },

        getContactPreferenceLabel() {
            const pref = this.contactPreferences.find(p => p.value === this.formData.contact_preference);
            return pref ? pref.label : '';
        },

        getSelectedDays() {
            return this.availableDays.filter(day => this.formData.availability_days.includes(day.value));
        },

        getTimeSlotLabel(slot) {
            const slots = {
                'morning': 'Matin (8h-12h)',
                'afternoon': 'Après-midi (14h-18h)',
                'evening': 'Soir (18h-20h)'
            };
            return slots[slot] || '';
        },

        async publishProject() {
            const formData = new FormData();
            
            // Ajouter les données du formulaire en tant que JSON
            formData.append('formData', JSON.stringify(this.formData));
            
            // Ajouter les photos
            if (this.formData.photos.length > 0) {
                this.formData.photos.forEach((photo, index) => {
                    formData.append(`photos[]`, photo.file);
                });
            }
            
            // Ajouter la vidéo si elle existe
            if (this.formData.video && this.formData.video.file) {
                formData.append('video', this.formData.video.file);
            }

            try {
                const response = await fetch('/projects', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        // Ne pas définir Content-Type, il sera automatiquement défini avec le boundary correct
                    }
                });

                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.error || 'Erreur lors de la publication');
                }

                // Redirection en cas de succès
                window.location.href = `/projects/${result.id}`;
                
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la publication du projet: ' + error.message);
            }
        },

        getBudgetDisplay() {
            if (!this.formData.budget) return 'Non spécifié';
            if (this.formData.budget_type === 'hourly') {
                const total = this.formData.estimated_hours * this.formData.budget;
                return `${this.formData.budget}€/h (environ ${total}€ pour ${this.formData.estimated_hours}h)`;
            }
            return `${this.formData.budget}€ (forfait)`;
        },
    }
}
</script>

<style>
/* Ajouts CSS pour l'optimisation mobile */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    input, select, textarea {
        font-size: 16px; /* Évite le zoom automatique sur iOS */
    }

    /* Améliore la taille des touches pour le mobile */
    button {
        min-height: 44px;
        min-width: 44px;
    }

    /* Ajuste les marges et paddings pour le mobile */
    .p-6 {
        padding: 1rem;
    }

    .space-y-6 > :not([hidden]) ~ :not([hidden]) {
        margin-top: 1rem;
    }
}
</style>
@endpush

@endsection

<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Créer un nouveau projet</h1>
        
        <form action="{{ route('projects.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-6 max-w-2xl">
            @csrf
            
            <!-- Le formulaire sera rempli via JavaScript dans le test -->
        </form>
    </div>
</x-app-layout>

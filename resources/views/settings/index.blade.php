<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-8">
                    <!-- Sécurité -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Sécurité</h3>
                        <div class="mt-5">
                            @if($isGoogleUser)
                                <p class="text-sm text-gray-600">Vous êtes connecté via Google. La gestion du mot de passe se fait via votre compte Google.</p>
                            @else
                                <form method="POST" action="{{ route('settings.password.update') }}" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                        <input type="password" name="current_password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>

                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                        <input type="password" name="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>

                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                                        Mettre à jour le mot de passe
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="pt-8 border-t">
                        <h3 class="text-lg font-medium text-gray-900">Notifications</h3>
                        <form method="POST" action="{{ route('settings.notifications.update') }}" class="mt-5">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="email_notifications" value="1" 
                                        {{ auth()->user()->email_notifications ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 rounded">
                                    <label class="ml-2 text-sm text-gray-700">Notifications par email</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="sms_notifications" value="1"
                                        {{ auth()->user()->sms_notifications ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 rounded">
                                    <label class="ml-2 text-sm text-gray-700">Notifications par SMS</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="newsletter" value="1"
                                        {{ auth()->user()->newsletter ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 rounded">
                                    <label class="ml-2 text-sm text-gray-700">Newsletter mensuelle</label>
                                </div>

                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                                    Sauvegarder les préférences
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Suppression du compte -->
                    <div class="pt-8 border-t">
                        <h3 class="text-lg font-medium text-red-600">Zone dangereuse</h3>
                        <div class="mt-5">
                            <div x-data="{ showConfirmation: false }">
                                <button @click="showConfirmation = true" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-md">
                                    Supprimer mon compte
                                </button>

                                <div x-show="showConfirmation" class="mt-4 p-4 bg-red-50 rounded-md">
                                    <p class="text-sm text-red-700">
                                        Cette action est irréversible. Pour confirmer, tapez "DELETE" ci-dessous.
                                    </p>
                                    <form method="POST" action="{{ route('settings.account.delete') }}" class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <input type="text" name="confirmation" required 
                                            class="mt-1 block w-full rounded-md border-red-300 shadow-sm">
                                        <button type="submit" 
                                            class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md">
                                            Confirmer la suppression
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

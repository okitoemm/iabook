<div x-show="showContactModal" 
     class="fixed inset-0 z-50 overflow-y-auto"
     x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div x-show="showContactModal"
             @click="showContactModal = false"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
        </div>

        <!-- Modal -->
        <div x-show="showContactModal"
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Contacter le client</h3>
                
                <form @submit.prevent="sendMessage">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <div class="mb-2">
                            <select x-model="selectedTemplate" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Choisir un template</option>
                                <template x-for="(template, index) in messageTemplates" :key="index">
                                    <option :value="template.content" x-text="template.title"></option>
                                </template>
                            </select>
                        </div>
                        <textarea x-model="messageContent"
                                  rows="6"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  required></textarea>
                    </div>
                    
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Envoyer
                        </button>
                        <button type="button"
                                @click="showContactModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

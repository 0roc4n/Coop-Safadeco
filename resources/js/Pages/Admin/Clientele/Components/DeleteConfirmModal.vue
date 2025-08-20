<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-red-50 to-orange-50 border-b border-red-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900">Delete Client</h3>
                        <p class="text-sm text-gray-600">This action cannot be undone</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="mb-4">
                    <p class="text-gray-700 mb-4">
                        Are you sure you want to delete this client? This will permanently remove all client information and cannot be reversed.
                    </p>
                    
                    <!-- Client Info Summary -->
                    <div v-if="client" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-red-500 to-pink-600 flex items-center justify-center text-white font-bold">
                                    {{ getInitials(client.FirstName, client.LastName) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ client.LastName }}, {{ client.FirstName }}
                                    <span v-if="client.MiddleName" class="text-gray-600">{{ client.MiddleName.charAt(0) }}.</span>
                                </div>
                                <div class="text-sm text-gray-500">{{ client.ClientCode }}</div>
                                <div v-if="client.Occupation" class="text-xs text-gray-400">{{ client.Occupation }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warning Notice -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-red-800">Warning</h4>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>All client records will be permanently deleted</li>
                                    <li>Related financial records may be affected</li>
                                    <li>This action cannot be undone</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button 
                        type="button" 
                        @click="$emit('close')" 
                        class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        @click="$emit('confirm')"
                        :disabled="isDeleting"
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    >
                        <svg v-if="isDeleting" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ isDeleting ? 'Deleting...' : 'Delete Client' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    show: Boolean,
    client: Object
});

const emit = defineEmits(['close', 'confirm']);

const isDeleting = ref(false);

const getInitials = (firstName, lastName) => {
    return (firstName?.charAt(0) || '') + (lastName?.charAt(0) || '');
};

// Handle confirm with loading state
const handleConfirm = () => {
    isDeleting.value = true;
    emit('confirm');
    
    // Reset deleting state after a delay
    setTimeout(() => {
        isDeleting.value = false;
    }, 1000);
};
</script>

<style scoped>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

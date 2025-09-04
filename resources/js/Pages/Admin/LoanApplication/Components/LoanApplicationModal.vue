<template>
    <DialogModal :show="show" max-width="4xl" @close="$emit('close')">
        <template #title>
            <div class="flex items-center space-x-2">
                <div class="p-2 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-lg font-semibold">{{ isEditing ? 'Edit Loan Application' : 'Create New Loan Application' }}</span>
            </div>
        </template>

        <template #content>
            <form @submit.prevent="submitForm" class="space-y-6">
                <!-- Client Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Client Name or Code <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                v-model="clientSearchQuery"
                                @input="searchClients"
                                @focus="showClientDropdown = true"
                                @blur="handleClientBlur"
                                type="text"
                                placeholder="Type client name or client code..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.ClientCode }"
                                required
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            
                            <!-- Dropdown for search results -->
                            <div v-if="showClientDropdown && filteredClients.length > 0" 
                                 class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <div v-for="client in filteredClients" 
                                     :key="client.ClientCode"
                                     @mousedown="selectClient(client)"
                                     class="px-3 py-2 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                    <div class="font-medium text-gray-900">{{ client.name }}</div>
                                    <div class="text-sm text-gray-600">Client Code: {{ client.ClientCode }}</div>
                                </div>
                            </div>
                            
                            <!-- No results message -->
                            <div v-if="showClientDropdown && clientSearchQuery && filteredClients.length === 0" 
                                 class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg p-3">
                                <div class="text-sm text-gray-500 text-center">
                                    No clients found matching "{{ clientSearchQuery }}"
                                </div>
                            </div>
                        </div>
                        
                        <!-- Selected client display -->
                        <div v-if="selectedClient" class="mt-2 p-2 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-blue-900">{{ selectedClient.name }}</div>
                                    <div class="text-sm text-blue-700">Client Code: {{ selectedClient.ClientCode }}</div>
                                </div>
                                <button @click="clearSelectedClient" type="button" class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <p v-if="errors.ClientCode" class="text-red-500 text-xs mt-1">{{ errors.ClientCode }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Application Date
                        </label>
                        <input
                            v-model="form.DtOfApp"
                            type="datetime-local"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            :class="{ 'border-red-500': errors.DtOfApp }"
                        >
                        <p v-if="errors.DtOfApp" class="text-red-500 text-xs mt-1">{{ errors.DtOfApp }}</p>
                    </div>
                </div>

                <!-- Loan Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Loan Type <span class="text-red-500">*</span>
                        </label>
                        <select
                            v-model="form.LoanType"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            :class="{ 'border-red-500': errors.LoanType }"
                            required
                        >
                            <option value="">Select loan type</option>
                            <option value="1">Personal Loan</option>
                            <option value="2">Business Loan</option>
                            <option value="3">Emergency Loan</option>
                            <option value="4">Educational Loan</option>
                            <option value="5">Housing Loan</option>
                        </select>
                        <p v-if="errors.LoanType" class="text-red-500 text-xs mt-1">{{ errors.LoanType }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Loan Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            v-model="form.LoanStatus"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            :class="{ 'border-red-500': errors.LoanStatus }"
                            required
                        >
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Rejected</option>
                            <option value="4">Completed</option>
                            <option value="5">Cancelled</option>
                        </select>
                        <p v-if="errors.LoanStatus" class="text-red-500 text-xs mt-1">{{ errors.LoanStatus }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Loan Number
                        </label>
                        <input
                            v-model="form.LoanNumber"
                            type="number"
                            min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            :class="{ 'border-red-500': errors.LoanNumber }"
                            placeholder="Enter loan number"
                        >
                        <p v-if="errors.LoanNumber" class="text-red-500 text-xs mt-1">{{ errors.LoanNumber }}</p>
                    </div>
                </div>

                <!-- Rating and Approval -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rating Score (0-10)
                        </label>
                        <input
                            v-model="form.RatingScore"
                            type="number"
                            min="0"
                            max="10"
                            step="0.1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            :class="{ 'border-red-500': errors.RatingScore }"
                            placeholder="0.0"
                        >
                        <p v-if="errors.RatingScore" class="text-red-500 text-xs mt-1">{{ errors.RatingScore }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Approval Status
                        </label>
                        <div class="flex items-center space-x-4 mt-3">
                            <label class="flex items-center">
                                <input
                                    v-model="form.Approved"
                                    type="radio"
                                    :value="0"
                                    class="mr-2 text-blue-600 focus:ring-blue-500"
                                >
                                <span class="text-sm text-gray-700">Pending</span>
                            </label>
                            <label class="flex items-center">
                                <input
                                    v-model="form.Approved"
                                    type="radio"
                                    :value="1"
                                    class="mr-2 text-blue-600 focus:ring-blue-500"
                                >
                                <span class="text-sm text-gray-700">Approved</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Remarks
                    </label>
                    <input
                        v-model="form.Remarks"
                        type="text"
                        maxlength="128"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        :class="{ 'border-red-500': errors.Remarks }"
                        placeholder="Brief remarks about the application"
                    >
                    <p v-if="errors.Remarks" class="text-red-500 text-xs mt-1">{{ errors.Remarks }}</p>
                </div>

                <!-- Application Remarks -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Application Details
                    </label>
                    <textarea
                        v-model="form.AppRemarks"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                        :class="{ 'border-red-500': errors.AppRemarks }"
                        placeholder="Detailed information about the loan application..."
                    ></textarea>
                    <p v-if="errors.AppRemarks" class="text-red-500 text-xs mt-1">{{ errors.AppRemarks }}</p>
                </div>
            </form>
        </template>

        <template #footer>
            <div class="flex items-center justify-end space-x-3">
                <button
                    @click="$emit('close')"
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    Cancel
                </button>
                <button
                    @click="submitForm"
                    :disabled="processing"
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="processing" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                    <span v-else>{{ isEditing ? 'Update Application' : 'Create Application' }}</span>
                </button>
            </div>
        </template>
    </DialogModal>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import DialogModal from '@/Components/DialogModal.vue'

const props = defineProps({
    show: Boolean,
    clients: Array,
    application: Object
})

const emit = defineEmits(['close', 'saved'])

// Form data
const form = ref({
    ClientCode: '',
    DtOfApp: '',
    LoanType: '',
    LoanStatus: 1,
    LoanNumber: '',
    RatingScore: '',
    Approved: 0,
    Remarks: '',
    AppRemarks: ''
})

// Client search functionality
const clientSearchQuery = ref('')
const showClientDropdown = ref(false)
const selectedClient = ref(null)
const filteredClients = ref([])
const searchTimeout = ref(null)

const errors = ref({})
const processing = ref(false)

const isEditing = computed(() => !!props.application?.LACode)

// Watch for application changes (editing)
watch(() => props.application, (newApplication) => {
    if (newApplication) {
        form.value = {
            ClientCode: newApplication.ClientCode || '',
            DtOfApp: newApplication.DtOfApp ? new Date(newApplication.DtOfApp).toISOString().slice(0, 16) : '',
            LoanType: newApplication.LoanType || '',
            LoanStatus: newApplication.LoanStatus || 1,
            LoanNumber: newApplication.LoanNumber || '',
            RatingScore: newApplication.RatingScore || '',
            Approved: newApplication.Approved || 0,
            Remarks: newApplication.Remarks || '',
            AppRemarks: newApplication.AppRemarks || ''
        }
        
        // Set selected client for editing
        if (newApplication.ClientCode && newApplication.clientele) {
            const client = {
                ClientCode: newApplication.ClientCode,
                name: `${newApplication.clientele.FirstName} ${newApplication.clientele.MiddleName || ''} ${newApplication.clientele.LastName}`.trim()
            }
            selectedClient.value = client
            clientSearchQuery.value = `${client.name} (${client.ClientCode})`
        }
    } else {
        // Reset form for new application
        form.value = {
            ClientCode: '',
            DtOfApp: '',
            LoanType: '',
            LoanStatus: 1,
            LoanNumber: '',
            RatingScore: '',
            Approved: 0,
            Remarks: '',
            AppRemarks: ''
        }
        
        // Reset client search
        selectedClient.value = null
        clientSearchQuery.value = ''
        showClientDropdown.value = false
        filteredClients.value = []
    }
    errors.value = {}
}, { immediate: true })

// Watch for show changes to reset form
watch(() => props.show, (show) => {
    if (!show) {
        errors.value = {}
        processing.value = false
        // Reset client search when modal closes
        selectedClient.value = null
        clientSearchQuery.value = ''
        showClientDropdown.value = false
        filteredClients.value = []
    }
})

// Client search methods with debouncing
const searchClients = () => {
    // Clear existing timeout
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value)
    }

    if (!clientSearchQuery.value || clientSearchQuery.value.length < 2) {
        filteredClients.value = []
        return
    }

    // Debounce the search
    searchTimeout.value = setTimeout(async () => {
        try {
            const response = await fetch(`${route('admin.loan-applications.search-clients')}?q=${encodeURIComponent(clientSearchQuery.value)}`)
            const clients = await response.json()
            filteredClients.value = clients
        } catch (error) {
            console.error('Error searching clients:', error)
            // Fallback to local search if API fails
            const query = clientSearchQuery.value.toLowerCase()
            filteredClients.value = props.clients.filter(client => {
                return client.name.toLowerCase().includes(query) || 
                       client.ClientCode.toLowerCase().includes(query)
            }).slice(0, 10)
        }
    }, 300) // 300ms delay
}

const selectClient = (client) => {
    selectedClient.value = client
    form.value.ClientCode = client.ClientCode
    clientSearchQuery.value = `${client.name} (${client.ClientCode})`
    showClientDropdown.value = false
}

const clearSelectedClient = () => {
    selectedClient.value = null
    form.value.ClientCode = ''
    clientSearchQuery.value = ''
    showClientDropdown.value = false
}

const handleClientBlur = () => {
    // Delay hiding dropdown to allow for click events
    setTimeout(() => {
        showClientDropdown.value = false
    }, 200)
}

const submitForm = () => {
    processing.value = true
    errors.value = {}

    const url = isEditing.value 
        ? route('admin.loan-applications.update', props.application.LACode)
        : route('admin.loan-applications.store')
    
    const method = isEditing.value ? 'put' : 'post'

    router[method](url, form.value, {
        onSuccess: () => {
            processing.value = false
            emit('saved', `Loan application ${isEditing.value ? 'updated' : 'created'} successfully!`)
        },
        onError: (serverErrors) => {
            processing.value = false
            errors.value = serverErrors
        }
    })
}
</script>

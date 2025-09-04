<template>
    <DialogModal :show="show" max-width="2xl" @close="$emit('close')">
        <template #title>
            <div class="flex items-center space-x-2">
                <div class="p-2 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-lg font-semibold">Loan Application Approval</span>
            </div>
        </template>

        <template #content>
            <div v-if="application" class="space-y-6">
                <!-- Application Summary -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Application Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Application Code:</span>
                            <span class="font-medium ml-2">#{{ application.LACode }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Client:</span>
                            <span class="font-medium ml-2">{{ getFullName(application.clientele) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Loan Type:</span>
                            <span class="font-medium ml-2">{{ getLoanTypeName(application.LoanType) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Application Date:</span>
                            <span class="font-medium ml-2">{{ formatDate(application.DtOfApp) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Approval Decision -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Approval Decision <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors" :class="{ 'border-green-500 bg-green-50': form.approved === true }">
                            <input
                                v-model="form.approved"
                                type="radio"
                                :value="true"
                                class="mr-3 text-green-600 focus:ring-green-500"
                            >
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-full mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Approve Application</p>
                                    <p class="text-sm text-gray-600">Grant approval for this loan application</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors" :class="{ 'border-red-500 bg-red-50': form.approved === false }">
                            <input
                                v-model="form.approved"
                                type="radio"
                                :value="false"
                                class="mr-3 text-red-600 focus:ring-red-500"
                            >
                            <div class="flex items-center">
                                <div class="p-2 bg-red-100 rounded-full mr-3">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Reject Application</p>
                                    <p class="text-sm text-gray-600">Decline this loan application</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    <p v-if="errors.approved" class="text-red-500 text-xs mt-1">{{ errors.approved }}</p>
                </div>

                <!-- Approval Remarks -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ form.approved ? 'Approval' : 'Rejection' }} Remarks
                        <span v-if="form.approved === false" class="text-red-500">*</span>
                    </label>
                    <textarea
                        v-model="form.remarks"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                        :class="{ 'border-red-500': errors.remarks }"
                        :placeholder="form.approved ? 'Optional remarks about the approval...' : 'Please provide reasons for rejection...'"
                    ></textarea>
                    <p v-if="errors.remarks" class="text-red-500 text-xs mt-1">{{ errors.remarks }}</p>
                </div>

                <!-- Warning for rejection -->
                <div v-if="form.approved === false" class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Important Notice</h3>
                            <p class="text-sm text-red-700 mt-1">
                                Rejecting this application will change its status to "Rejected" and notify the client. This action can be reversed by editing the application later.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
                    @click="submitApproval"
                    :disabled="processing || form.approved === null"
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors focus:outline-none focus:ring-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    :class="form.approved ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-red-600 hover:bg-red-700 focus:ring-red-500'"
                >
                    <span v-if="processing" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                    <span v-else>{{ form.approved ? 'Approve Application' : 'Reject Application' }}</span>
                </button>
            </div>
        </template>
    </DialogModal>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import DialogModal from '@/Components/DialogModal.vue'

const props = defineProps({
    show: Boolean,
    application: Object
})

const emit = defineEmits(['close', 'approved'])

// Form data
const form = ref({
    approved: null,
    remarks: ''
})

const errors = ref({})
const processing = ref(false)

// Watch for show changes to reset form
watch(() => props.show, (show) => {
    if (show) {
        form.value = {
            approved: null,
            remarks: ''
        }
        errors.value = {}
        processing.value = false
    }
})

// Helper methods
const getFullName = (clientele) => {
    if (!clientele) return 'N/A'
    const parts = [clientele.FirstName, clientele.MiddleName, clientele.LastName].filter(Boolean)
    return parts.join(' ')
}

const formatDate = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const getLoanTypeName = (type) => {
    const types = {
        1: 'Personal Loan',
        2: 'Business Loan',
        3: 'Emergency Loan',
        4: 'Educational Loan',
        5: 'Housing Loan'
    }
    return types[type] || 'Unknown'
}

const submitApproval = () => {
    // Validate required fields
    errors.value = {}
    
    if (form.value.approved === null) {
        errors.value.approved = 'Please select an approval decision'
        return
    }
    
    if (form.value.approved === false && !form.value.remarks.trim()) {
        errors.value.remarks = 'Rejection remarks are required'
        return
    }

    processing.value = true

    router.patch(route('admin.loan-applications.approval', props.application.LACode), {
        approved: form.value.approved,
        remarks: form.value.remarks
    }, {
        onSuccess: () => {
            processing.value = false
            const status = form.value.approved ? 'approved' : 'rejected'
            emit('approved', `Loan application has been ${status} successfully!`)
        },
        onError: (serverErrors) => {
            processing.value = false
            errors.value = serverErrors
        }
    })
}
</script>

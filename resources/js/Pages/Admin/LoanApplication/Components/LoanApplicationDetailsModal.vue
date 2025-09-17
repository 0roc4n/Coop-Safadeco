<template>
    <DialogModal :show="show" max-width="3xl" @close="$emit('close')">
        <template #title>
            <div class="flex items-center space-x-2">
                <div class="p-2 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <span class="text-lg font-semibold">Loan Application Details</span>
            </div>
        </template>

        <template #content>
            <div v-if="application" class="space-y-6">
                <!-- Application Header -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Application #{{ application.LACode }}</h3>
                            <p class="text-sm text-gray-600">Applied on {{ formatDate(application.DtOfApp) }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full" :class="getStatusClass(application.LoanStatus)">
                                {{ getStatusName(application.LoanStatus) }}
                            </span>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full" :class="getApprovalClass(application.Approved)">
                                {{ application.Approved ? 'Approved' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Client Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Client Information
                        </h4>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ getInitials(application.clientele) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ getFullName(application.clientele) }}</p>
                                    <p class="text-sm text-gray-500">Client Code: {{ application.ClientCode }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Loan Information
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Loan Type:</span>
                                <span class="text-sm font-medium">{{ getLoanTypeName(application.LoanType) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Loan Number:</span>
                                <span class="text-sm font-medium">{{ application.LoanNumber || 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Rating Score:</span>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium mr-2">{{ application.RatingScore || 'N/A' }}</span>
                                    <div v-if="application.RatingScore" class="flex">
                                        <svg v-for="i in 5" :key="i" class="w-4 h-4" :class="i <= Math.floor(application.RatingScore / 2) ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approval Information -->
                <div v-if="application.Approved" class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-green-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Approval Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-green-700">Approved by:</span>
                            <span class="text-sm font-medium text-green-900">{{ application.UserApproved || 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-green-700">Approval Date:</span>
                            <span class="text-sm font-medium text-green-900">{{ formatDate(application.ApproveDate) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Remarks Section -->
                <div class="space-y-4">
                    <div v-if="application.Remarks" class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Remarks
                        </h4>
                        <p class="text-sm text-gray-700">{{ application.Remarks }}</p>
                    </div>

                    <div v-if="application.AppRemarks" class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Application Details
                        </h4>
                        <div class="prose prose-sm max-w-none">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ application.AppRemarks }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="text-md font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Application Submitted</p>
                                <p class="text-xs text-gray-500">{{ formatDate(application.DtOfApp) }}</p>
                            </div>
                        </div>
                        <div v-if="application.Approved" class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Application Approved</p>
                                <p class="text-xs text-gray-500">{{ formatDate(application.ApproveDate) }} by {{ application.UserApproved }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 bg-gray-300 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                <p class="text-xs text-gray-500">{{ formatDate(application.updated_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #footer>
            <div class="flex items-center justify-end">
                <button
                    @click="$emit('close')"
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    Close
                </button>
            </div>
        </template>
    </DialogModal>
</template>

<script setup>
import DialogModal from '@/Components/DialogModal.vue'

defineProps({
    show: Boolean,
    application: Object
})

defineEmits(['close'])

// Helper methods
const getInitials = (clientele) => {
    if (!clientele) return 'N/A'
    const firstName = clientele.FirstName || ''
    const lastName = clientele.LastName || ''
    return (firstName.charAt(0) + lastName.charAt(0)).toUpperCase()
}

const getFullName = (clientele) => {
    if (!clientele) return 'N/A'
    const parts = [clientele.FirstName, clientele.MiddleName, clientele.LastName].filter(Boolean)
    return parts.join(' ')
}

const formatDate = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
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

const getStatusName = (status) => {
    const statuses = {
        1: 'Pending',
        2: 'Approved',
        3: 'Rejected',
        4: 'Completed',
        5: 'Cancelled'
    }
    return statuses[status] || 'Unknown'
}

const getStatusClass = (status) => {
    const classes = {
        1: 'bg-yellow-100 text-yellow-800',
        2: 'bg-green-100 text-green-800',
        3: 'bg-red-100 text-red-800',
        4: 'bg-blue-100 text-blue-800',
        5: 'bg-gray-100 text-gray-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getApprovalClass = (approved) => {
    return approved 
        ? 'bg-green-100 text-green-800' 
        : 'bg-yellow-100 text-yellow-800'
}
</script>

<template>
    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Loan Applications List</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">
                        Showing {{ applications.from || 0 }} to {{ applications.to || 0 }} of {{ applications.total || 0 }} results
                    </span>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th @click="$emit('sort', 'LACode')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-1">
                                <span>Application Code</span>
                                <svg v-if="sort.field === 'LACode'" class="w-4 h-4" :class="sort.direction === 'asc' ? 'transform rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th @click="$emit('sort', 'DtOfApp')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-1">
                                <span>Application Date</span>
                                <svg v-if="sort.field === 'DtOfApp'" class="w-4 h-4" :class="sort.direction === 'asc' ? 'transform rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="application in applications.data" :key="application.LACode" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ application.LACode }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                        {{ getInitials(application.clientele) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ getFullName(application.clientele) }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ application.ClientCode }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ formatDate(application.DtOfApp) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ application.LoanNumber || 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ getLoanTypeName(application.LoanType) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getStatusClass(application.LoanStatus)">
                                {{ getStatusName(application.LoanStatus) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getApprovalClass(application.Approved)">
                                {{ application.Approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <span class="text-sm font-medium">{{ application.RatingScore || 'N/A' }}</span>
                                <div v-if="application.RatingScore" class="ml-2 flex">
                                    <svg v-for="i in 5" :key="i" class="w-4 h-4" :class="i <= Math.floor(application.RatingScore / 2) ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- View Button -->
                                <button @click="$emit('view', application)" class="text-blue-600 hover:text-blue-900 transition-colors" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>

                                <!-- Edit Button -->
                                <button @click="$emit('edit', application)" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                <!-- Approval Button -->
                                <button v-if="!application.Approved" @click="$emit('approve', application)" class="text-green-600 hover:text-green-900 transition-colors" title="Approve/Reject">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>

                                <!-- Delete Button -->
                                <button @click="$emit('delete', application)" class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ applications.from || 0 }} to {{ applications.to || 0 }} of {{ applications.total || 0 }} results
                </div>
                <div class="flex items-center space-x-2">
                    <Link 
                        v-if="applications.prev_page_url"
                        :href="applications.prev_page_url"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                    >
                        Previous
                    </Link>
                    
                    <template v-for="(link, index) in applications.links" :key="index">
                        <Link 
                            v-if="link.url && !link.label.includes('Previous') && !link.label.includes('Next')"
                            :href="link.url"
                            class="px-3 py-2 text-sm font-medium rounded-md transition-colors"
                            :class="link.active 
                                ? 'bg-blue-600 text-white border border-blue-600' 
                                : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50'"
                            v-html="link.label"
                        />
                    </template>
                    
                    <Link 
                        v-if="applications.next_page_url"
                        :href="applications.next_page_url"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                    >
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    applications: Object,
    sort: Object
})

defineEmits(['sort', 'view', 'edit', 'approve', 'delete'])

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
        month: 'short',
        day: 'numeric'
    })
}

const getLoanTypeName = (type) => {
    const types = {
        1: 'Personal',
        2: 'Business',
        3: 'Emergency',
        4: 'Educational',
        5: 'Housing'
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

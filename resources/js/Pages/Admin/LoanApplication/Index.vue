<template>
    <Head>
        <title>Loan Applications Management - SAFADECO Cooperative</title>
        <meta name="description" content="Manage and process loan applications for SAFADECO cooperative members. View, approve, edit and track loan application status efficiently." />
        <meta name="keywords" content="loan applications, SAFADECO, cooperative loans, loan management, financial services" />
        <meta property="og:title" content="Loan Applications Management - SAFADECO Cooperative" />
        <meta property="og:description" content="Comprehensive loan application management system for SAFADECO cooperative members" />
        <meta property="og:type" content="website" />
        <link rel="canonical" :href="route('admin.loan-applications.index')" />
    </Head>
    <AppLayout title="Loan Applications Management">
        <div class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Loan Applications</h1>
                                <p class="text-gray-600 mt-1">Manage and process loan applications for SAFADECO members</p>
                            </div>
                            
                            <!-- Create Loan Application Button -->
                            <button 
                                @click="showCreateModal = true"
                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                New Loan Application
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Toast Notification -->
                <Toast v-if="toastMessage" :message="toastMessage" :type="toastType" @close="toastMessage = ''" />

                <!-- Search and Filter Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search Input -->
                            <div class="lg:col-span-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input 
                                        v-model="searchQuery"
                                        type="text" 
                                        placeholder="Search by client name, loan number, or application code..."
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                        @input="performSearch"
                                    >
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <select 
                                    v-model="selectedStatus"
                                    @change="performSearch"
                                    class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                >
                                    <option value="all">All Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Approved</option>
                                    <option value="3">Rejected</option>
                                    <option value="4">Completed</option>
                                </select>
                            </div>

                            <!-- Approval Filter -->
                            <div>
                                <select 
                                    v-model="selectedApproved"
                                    @change="performSearch"
                                    class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                >
                                    <option value="all">All Approvals</option>
                                    <option value="1">Approved</option>
                                    <option value="0">Pending Approval</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Applications</p>
                                <p class="text-2xl font-bold">{{ loanApplications.total || 0 }}</p>
                            </div>
                            <div class="bg-blue-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Approved</p>
                                <p class="text-2xl font-bold">{{ approvedCount }}</p>
                            </div>
                            <div class="bg-green-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm font-medium">Pending</p>
                                <p class="text-2xl font-bold">{{ pendingCount }}</p>
                            </div>
                            <div class="bg-yellow-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm font-medium">Rejected</p>
                                <p class="text-2xl font-bold">{{ rejectedCount }}</p>
                            </div>
                            <div class="bg-red-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <LoanApplicationTable 
                    :applications="loanApplications"
                    :sort="sort"
                    @sort="sortBy"
                    @view="viewApplication"
                    @edit="editApplication"
                    @approve="showApprovalModal"
                    @delete="confirmDelete"
                />
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <LoanApplicationModal 
            :show="showCreateModal" 
            :clients="clients"
            :application="selectedApplication"
            @close="closeModal"
            @saved="handleSaved"
        />

        <!-- View Details Modal -->
        <LoanApplicationDetailsModal 
            :show="showDetailsModal"
            :application="selectedApplication"
            @close="showDetailsModal = false"
        />

        <!-- Approval Modal -->
        <ApprovalModal
            :show="showApprovalModalFlag"
            :application="selectedApplication"
            @close="showApprovalModalFlag = false"
            @approved="handleApprovalUpdate"
        />

        <!-- Delete Confirmation Modal -->
        <ConfirmationModal 
            :show="showDeleteModal" 
            @close="showDeleteModal = false"
        >
            <template #title>Delete Loan Application</template>
            <template #content>
                Are you sure you want to delete this loan application? This action cannot be undone.
            </template>
            <template #footer>
                <button @click="showDeleteModal = false" class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button @click="deleteApplication" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Toast from '@/Components/Toast.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import LoanApplicationModal from './Components/LoanApplicationModal.vue'
import LoanApplicationDetailsModal from './Components/LoanApplicationDetailsModal.vue'
import ApprovalModal from './Components/ApprovalModal.vue'
import LoanApplicationTable from './Components/LoanApplicationTable.vue'

// Props
const props = defineProps({
    loanApplications: Object,
    clients: Array,
    filters: Object,
    sort: Object
})

// Reactive data
const searchQuery = ref(props.filters.search || '')
const selectedStatus = ref(props.filters.status || 'all')
const selectedApproved = ref(props.filters.approved || 'all')
const showCreateModal = ref(false)
const showDetailsModal = ref(false)
const showApprovalModalFlag = ref(false)
const showDeleteModal = ref(false)
const selectedApplication = ref(null)
const toastMessage = ref('')
const toastType = ref('success')
const sort = ref(props.sort)

// Computed properties
const approvedCount = computed(() => {
    return props.loanApplications.data?.filter(app => app.Approved === 1).length || 0
})

const pendingCount = computed(() => {
    return props.loanApplications.data?.filter(app => app.LoanStatus === 1).length || 0
})

const rejectedCount = computed(() => {
    return props.loanApplications.data?.filter(app => app.LoanStatus === 3).length || 0
})

// Methods
const performSearch = () => {
    router.get(route('admin.loan-applications.index'), {
        search: searchQuery.value,
        status: selectedStatus.value,
        approved: selectedApproved.value,
        sort: sort.value.field,
        direction: sort.value.direction
    }, {
        preserveState: true,
        replace: true
    })
}

const sortBy = (field) => {
    if (sort.value.field === field) {
        sort.value.direction = sort.value.direction === 'asc' ? 'desc' : 'asc'
    } else {
        sort.value.field = field
        sort.value.direction = 'asc'
    }
    performSearch()
}

const viewApplication = (application) => {
    selectedApplication.value = application
    showDetailsModal.value = true
}

const editApplication = (application) => {
    selectedApplication.value = application
    showCreateModal.value = true
}

const showApprovalModal = (application) => {
    selectedApplication.value = application
    showApprovalModalFlag.value = true
}

const confirmDelete = (application) => {
    selectedApplication.value = application
    showDeleteModal.value = true
}

const deleteApplication = () => {
    router.delete(route('admin.loan-applications.destroy', selectedApplication.value.LACode), {
        onSuccess: () => {
            showDeleteModal.value = false
            selectedApplication.value = null
            showToast('Loan application deleted successfully!', 'success')
        },
        onError: (errors) => {
            showToast(errors.error || 'Failed to delete loan application', 'error')
        }
    })
}

const closeModal = () => {
    showCreateModal.value = false
    selectedApplication.value = null
}

const handleSaved = (message) => {
    closeModal()
    showToast(message, 'success')
}

const handleApprovalUpdate = (message) => {
    showApprovalModalFlag.value = false
    selectedApplication.value = null
    showToast(message, 'success')
}

const showToast = (message, type = 'success') => {
    toastMessage.value = message
    toastType.value = type
    setTimeout(() => {
        toastMessage.value = ''
    }, 5000)
}

// Handle flash messages
onMounted(() => {
    if (window.history.state?.success) {
        showToast(window.history.state.success, 'success')
    }
    if (window.history.state?.error) {
        showToast(window.history.state.error, 'error')
    }
})
</script>

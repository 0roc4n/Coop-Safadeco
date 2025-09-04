<template>
    <Head>
        <title>{{ clientFullName }} - Client Details - SAFADECO Cooperative</title>
        <meta name="description" :content="`View detailed information for ${clientFullName}, member of SAFADECO cooperative`" />
    </Head>
    <AppLayout :title="`Client Details - ${clientFullName}`">
        <div class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex items-center space-x-4">
                                <Link :href="route('admin.clientele.index')" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back to Clients
                                </Link>
                                <div class="flex items-center space-x-4">
                                    <div class="h-16 w-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                                        {{ getInitials(clientele.FirstName, clientele.LastName) }}
                                    </div>
                                    <div>
                                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ clientFullName }}</h1>
                                        <p class="text-gray-600 mt-1">Client Code: {{ clientele.ClientCode }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Export Buttons -->
                            <div class="flex items-center space-x-3">
                                <button 
                                    @click="exportToPdf"
                                    class="inline-flex items-center px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-lg hover:shadow-xl"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export PDF
                                </button>
                                <button 
                                    @click="exportToExcel"
                                    class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-lg hover:shadow-xl"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Membership Status</p>
                                <p class="text-xl font-bold">{{ membershipStatus }}</p>
                            </div>
                            <div class="bg-blue-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Total Loans</p>
                                <p class="text-xl font-bold">{{ loanStats.total || 0 }}</p>
                            </div>
                            <div class="bg-green-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Approved Loans</p>
                                <p class="text-xl font-bold">{{ loanStats.approved || 0 }}</p>
                            </div>
                            <div class="bg-purple-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Personal Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information Card -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Personal Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">First Name</label>
                                            <p class="text-gray-900">{{ clientele.FirstName || 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Middle Name</label>
                                            <p class="text-gray-900">{{ clientele.MiddleName || 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Last Name</label>
                                            <p class="text-gray-900">{{ clientele.LastName || 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Date of Birth</label>
                                            <p class="text-gray-900">{{ formatDate(clientele.DtBirth) }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Gender</label>
                                            <p class="text-gray-900">{{ clientele.Sex ? 'Male' : 'Female' }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Client Type</label>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ getClientTypeName(clientele.ClientType) }}
                                            </span>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Date of Membership</label>
                                            <p class="text-gray-900">{{ formatDate(clientele.DateOfMembership) }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Occupation</label>
                                            <p class="text-gray-900">{{ clientele.Occupation || 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Monthly Salary</label>
                                            <p class="text-gray-900">₱{{ formatCurrency(clientele.MonthlySalary) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Card -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Contact Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Address</label>
                                        <p class="text-gray-900">{{ clientele.Addr1 || 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Phone Number</label>
                                        <p class="text-gray-900">{{ clientele.TelNum || 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Information Card -->
                        <div v-if="clientele.clientele_details" class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Additional Details
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-3">
                                        <div v-if="clientele.clientele_details.SSS">
                                            <label class="text-sm font-medium text-gray-700">SSS Number</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.SSS }}</p>
                                        </div>
                                        <div v-if="clientele.clientele_details.TIN">
                                            <label class="text-sm font-medium text-gray-700">TIN</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.TIN }}</p>
                                        </div>
                                        <div v-if="clientele.clientele_details.Height">
                                            <label class="text-sm font-medium text-gray-700">Height</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.Height }}</p>
                                        </div>
                                        <div v-if="clientele.clientele_details.Weight">
                                            <label class="text-sm font-medium text-gray-700">Weight</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.Weight }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div v-if="clientele.clientele_details.EmployerName">
                                            <label class="text-sm font-medium text-gray-700">Employer</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.EmployerName }}</p>
                                        </div>
                                        <div v-if="clientele.clientele_details.OfficeAddress">
                                            <label class="text-sm font-medium text-gray-700">Office Address</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.OfficeAddress }}</p>
                                        </div>
                                        <div v-if="clientele.clientele_details.Degree">
                                            <label class="text-sm font-medium text-gray-700">Educational Degree</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.Degree }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Spouse Information Card -->
                        <div v-if="clientele.SpouseName" class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Spouse Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Spouse Name</label>
                                            <p class="text-gray-900">{{ clientele.SpouseName }}</p>
                                        </div>
                                        <div v-if="clientele.SpouseOcc">
                                            <label class="text-sm font-medium text-gray-700">Spouse Occupation</label>
                                            <p class="text-gray-900">{{ clientele.SpouseOcc }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div v-if="clientele.SpouseMonSal">
                                            <label class="text-sm font-medium text-gray-700">Spouse Monthly Salary</label>
                                            <p class="text-gray-900">₱{{ formatCurrency(clientele.SpouseMonSal) }}</p>
                                        </div>
                                        <div v-if="clientele.clientele_details?.SpouseContactNo">
                                            <label class="text-sm font-medium text-gray-700">Spouse Contact</label>
                                            <p class="text-gray-900">{{ clientele.clientele_details.SpouseContactNo }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Membership Summary -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Membership Summary</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Member Since</span>
                                        <span class="font-medium">{{ formatDate(clientele.DateOfMembership) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Member Type</span>
                                        <span class="font-medium">{{ getClientTypeName(clientele.ClientType) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Status</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Loan Applications -->
                        <div v-if="loanApplications.length > 0" class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Loan Applications</h3>
                                <div class="space-y-3">
                                    <div v-for="loan in loanApplications" :key="loan.LACode" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900">#{{ loan.LACode }}</p>
                                            <p class="text-sm text-gray-600">{{ formatDate(loan.DtOfApp) }}</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getLoanStatusClass(loan.LoanStatus)">
                                            {{ getLoanStatusName(loan.LoanStatus) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                                <div class="space-y-3">
                                    <Link 
                                        :href="route('admin.loan-applications.create')" 
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        New Loan Application
                                    </Link>
                                    <button 
                                        @click="editClient"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Client
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    clientele: Object,
    loanApplications: Array,
    loanStats: Object
})

// Computed properties
const clientFullName = computed(() => {
    const parts = [props.clientele.FirstName, props.clientele.MiddleName, props.clientele.LastName].filter(Boolean)
    return parts.join(' ')
})

const membershipStatus = computed(() => {
    if (props.clientele.DateOfMembership) {
        const membershipDate = new Date(props.clientele.DateOfMembership)
        const now = new Date()
        if (membershipDate <= now) {
            return 'Active Member'
        }
    }
    return 'Inactive'
})

// Methods
const getInitials = (firstName, lastName) => {
    return (firstName?.charAt(0) || '') + (lastName?.charAt(0) || '')
}

const formatDate = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatCurrency = (amount) => {
    if (!amount) return '0.00'
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount)
}

const getClientTypeName = (type) => {
    const types = {
        1: 'Regular Member',
        2: 'Associate Member',
        3: 'Honorary Member'
    }
    return types[type] || 'Unknown'
}

const getLoanStatusName = (status) => {
    const statuses = {
        1: 'Pending',
        2: 'Approved',
        3: 'Rejected',
        4: 'Completed',
        5: 'Cancelled'
    }
    return statuses[status] || 'Unknown'
}

const getLoanStatusClass = (status) => {
    const classes = {
        1: 'bg-yellow-100 text-yellow-800',
        2: 'bg-green-100 text-green-800',
        3: 'bg-red-100 text-red-800',
        4: 'bg-blue-100 text-blue-800',
        5: 'bg-gray-100 text-gray-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const exportToPdf = () => {
    window.open(route('admin.clientele.export', { clientCode: props.clientele.ClientCode, format: 'pdf' }), '_blank')
}

const exportToExcel = () => {
    window.open(route('admin.clientele.export', { clientCode: props.clientele.ClientCode, format: 'excel' }), '_blank')
}

const editClient = () => {
    // Navigate back to index with edit modal open
    window.location.href = route('admin.clientele.index') + '?edit=' + props.clientele.ClientCode
}
</script>

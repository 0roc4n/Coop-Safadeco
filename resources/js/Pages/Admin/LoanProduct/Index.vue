<template>
    <Head>
        <title>Loan Products Management - SAFADECO Cooperative</title>
        <meta name="description" content="Manage loan products and configurations for SAFADECO cooperative lending services" />
        <meta name="keywords" content="loan products, SAFADECO, cooperative loans, financial products, lending" />
    </Head>
    <AppLayout title="Loan Products Management">
        <div class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Loan Products</h1>
                                <p class="text-gray-600 mt-1">Manage and configure loan products for SAFADECO members</p>
                            </div>
                            
                            <!-- Create Loan Product Button -->
                            <button 
                                @click="showCreateModal = true"
                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white text-sm font-medium rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                New Loan Product
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Toast Notification -->
                <Toast v-if="toastMessage" :message="toastMessage" :type="toastType" @close="toastMessage = ''" />

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Products</p>
                                <p class="text-2xl font-bold">{{ statistics.total_products || 0 }}</p>
                            </div>
                            <div class="bg-blue-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Active Products</p>
                                <p class="text-2xl font-bold">{{ statistics.active_products || 0 }}</p>
                            </div>
                            <div class="bg-green-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Collateral Required</p>
                                <p class="text-2xl font-bold">{{ statistics.collateral_required || 0 }}</p>
                            </div>
                            <div class="bg-purple-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-xl text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Avg. Interest Rate</p>
                                <p class="text-2xl font-bold">{{ statistics.average_interest_rate || 0 }}%</p>
                            </div>
                            <div class="bg-orange-400/30 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

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
                                            placeholder="Search by loan code or description..."
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                            @input="debouncedSearch"
                                        >
                                </div>
                            </div>

                            <!-- Loan Type Filter -->
                            <div>
                                <select 
                                    v-model="selectedLoanType"
                                    @change="performSearch"
                                    class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                >
                                    <option value="all">All Loan Types</option>
                                    <option value="1">Personal Loan</option>
                                    <option value="2">Business Loan</option>
                                    <option value="3">Emergency Loan</option>
                                    <option value="4">Educational Loan</option>
                                    <option value="5">Housing Loan</option>
                                </select>
                            </div>

                            <!-- Collateral Filter -->
                            <div>
                                <select 
                                    v-model="selectedCollateral"
                                    @change="performSearch"
                                    class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                >
                                    <option value="all">All Collateral Types</option>
                                    <option value="1">Collateral Required</option>
                                    <option value="0">No Collateral</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 overflow-hidden relative">
                    <!-- Loading Overlay -->
                    <div v-if="isLoading" class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-10">
                        <div class="flex items-center space-x-3">
                            <svg class="animate-spin h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-600 font-medium">Loading products...</span>
                        </div>
                    </div>
                    <!-- Table Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Loan Products List</h3>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">
                                    Showing {{ loanProducts.from || 0 }} to {{ loanProducts.to || 0 }} of {{ loanProducts.total || 0 }} results
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <!-- Mobile-friendly table for small screens -->
                            <div class="block sm:hidden">
                                <div v-if="!loanProducts.data || loanProducts.data.length === 0" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">No loan products found</h3>
                                            <p class="text-gray-500 mt-1">Get started by creating your first loan product.</p>
                                        </div>
                                        <button 
                                            @click="showCreateModal = true"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create Loan Product
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Mobile Card Layout -->
                                <div v-for="product in loanProducts.data" :key="product.LoanCode" class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ product.LoanCode }}</h3>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getLoanTypeClass(product.LoanType)">
                                            {{ getLoanTypeName(product.LoanType) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm">
                                        <p class="text-gray-600 truncate">{{ product.Description }}</p>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Interest Rate:</span>
                                            <span class="font-medium">{{ formatPercentage(product.InterestRate) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Loan Range:</span>
                                            <span class="font-medium">₱{{ formatCurrency(product.MinLoanAmount) }} - ₱{{ formatCurrency(product.MaxLoanAmount) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Term Range:</span>
                                            <span class="font-medium">{{ product.MinTerm }} - {{ product.MaxTerm }} months</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200">
                                        <div class="flex flex-wrap gap-1">
                                            <span v-if="product.HasCollateral" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Collateral
                                            </span>
                                            <span v-if="product.HasCoMaker" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Co-maker
                                            </span>
                                            <span v-if="!product.HasCollateral && !product.HasCoMaker" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                None
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button @click="viewProduct(product)" class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button @click="editProduct(product)" class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button @click="confirmDelete(product)" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </table>
                        
                        <!-- Desktop Table -->
                        <table class="min-w-full divide-y divide-gray-200 hidden sm:table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th @click="sortBy('LoanCode')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center space-x-1">
                                            <span>Loan Code</span>
                                            <svg v-if="sort.field === 'LoanCode'" class="w-4 h-4" :class="sort.direction === 'asc' ? 'transform rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Type</th>
                                    <th @click="sortBy('InterestRate')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center space-x-1">
                                            <span>Interest Rate</span>
                                            <svg v-if="sort.field === 'InterestRate'" class="w-4 h-4" :class="sort.direction === 'asc' ? 'transform rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Range</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Term Range</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirements</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Empty State -->
                                <tr v-if="!loanProducts.data || loanProducts.data.length === 0">
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900">No loan products found</h3>
                                                <p class="text-gray-500 mt-1">Get started by creating your first loan product.</p>
                                            </div>
                                            <button 
                                                @click="showCreateModal = true"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Create Loan Product
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Data Rows -->
                                <tr v-for="product in loanProducts.data" :key="product.LoanCode" class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ product.LoanCode }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" :title="product.Description">
                                            {{ product.Description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getLoanTypeClass(product.LoanType)">
                                            {{ getLoanTypeName(product.LoanType) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ formatPercentage(product.InterestRate) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium">₱{{ formatCurrency(product.MinLoanAmount) }}</div>
                                            <div class="text-xs text-gray-500">to ₱{{ formatCurrency(product.MaxLoanAmount) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ product.MinTerm }} - {{ product.MaxTerm }} months</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            <span v-if="product.HasCollateral" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Collateral
                                            </span>
                                            <span v-if="product.HasCoMaker" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Co-maker
                                            </span>
                                            <span v-if="!product.HasCollateral && !product.HasCoMaker" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                None
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-1">
                                            <!-- View Button -->
                                            <button @click="viewProduct(product)" class="inline-flex items-center p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>

                                            <!-- Edit Button -->
                                            <button @click="editProduct(product)" class="inline-flex items-center p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>

                                            <!-- Delete Button -->
                                            <button @click="confirmDelete(product)" class="inline-flex items-center p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ loanProducts.from || 0 }}</span> to <span class="font-medium">{{ loanProducts.to || 0 }}</span> of <span class="font-medium">{{ loanProducts.total || 0 }}</span> results
                            </div>
                            <div class="flex items-center space-x-1">
                                <Link 
                                    v-if="loanProducts.prev_page_url"
                                    :href="loanProducts.prev_page_url"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Previous
                                </Link>
                                
                                <template v-for="(link, index) in loanProducts.links" :key="index">
                                    <Link 
                                        v-if="link.url && !link.label.includes('Previous') && !link.label.includes('Next')"
                                        :href="link.url"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium border transition-colors"
                                        :class="link.active 
                                            ? 'bg-green-600 text-white border-green-600 z-10' 
                                            : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-50'"
                                        v-html="link.label"
                                    />
                                </template>
                                
                                <Link 
                                    v-if="loanProducts.next_page_url"
                                    :href="loanProducts.next_page_url"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 transition-colors"
                                >
                                    Next
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <LoanProductModal 
            :show="showCreateModal" 
            :product="selectedProduct"
            @close="closeModal"
            @saved="handleSaved"
        />

        <!-- View Details Modal -->
        <LoanProductDetailsModal 
            :show="showDetailsModal"
            :product="selectedProduct"
            @close="showDetailsModal = false"
        />

        <!-- Delete Confirmation Modal -->
        <ConfirmationModal 
            :show="showDeleteModal" 
            @close="showDeleteModal = false"
        >
            <template #title>Delete Loan Product</template>
            <template #content>
                Are you sure you want to delete this loan product? This action cannot be undone and may affect existing loan applications.
            </template>
            <template #footer>
                <button @click="showDeleteModal = false" class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button @click="deleteProduct" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors">
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
import LoanProductModal from './Components/LoanProductModal.vue'
import LoanProductDetailsModal from './Components/LoanProductDetailsModal.vue'

// Props
const props = defineProps({
    loanProducts: Object,
    statistics: Object,
    filters: Object,
    sort: Object
})

// Reactive data
const searchQuery = ref(props.filters.search || '')
const selectedLoanType = ref(props.filters.loan_type || 'all')
const selectedCollateral = ref(props.filters.has_collateral || 'all')
const showCreateModal = ref(false)
const showDetailsModal = ref(false)
const showDeleteModal = ref(false)
const selectedProduct = ref(null)
const toastMessage = ref('')
const toastType = ref('success')
const sort = ref(props.sort)
const isLoading = ref(false)
const searchTimeout = ref(null)

// Methods
const performSearch = () => {
    isLoading.value = true
    router.get(route('admin.loan-products.index'), {
        search: searchQuery.value,
        loan_type: selectedLoanType.value,
        has_collateral: selectedCollateral.value,
        sort: sort.value.field,
        direction: sort.value.direction
    }, {
        preserveState: true,
        replace: true,
        onFinish: () => {
            isLoading.value = false
        }
    })
}

const debouncedSearch = () => {
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value)
    }
    searchTimeout.value = setTimeout(() => {
        performSearch()
    }, 300)
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

const getLoanTypeClass = (type) => {
    const classes = {
        1: 'bg-blue-100 text-blue-800',
        2: 'bg-green-100 text-green-800',
        3: 'bg-red-100 text-red-800',
        4: 'bg-purple-100 text-purple-800',
        5: 'bg-yellow-100 text-yellow-800'
    }
    return classes[type] || 'bg-gray-100 text-gray-800'
}

const formatCurrency = (amount) => {
    if (!amount) return '0.00'
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount)
}

const formatPercentage = (rate) => {
    if (!rate) return '0.00%'
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(rate) + '%'
}

const viewProduct = (product) => {
    selectedProduct.value = product
    showDetailsModal.value = true
}

const editProduct = (product) => {
    selectedProduct.value = product
    showCreateModal.value = true
}

const confirmDelete = (product) => {
    selectedProduct.value = product
    showDeleteModal.value = true
}

const deleteProduct = () => {
    router.delete(route('admin.loan-products.destroy', selectedProduct.value.LoanCode), {
        onSuccess: () => {
            showDeleteModal.value = false
            selectedProduct.value = null
            showToast('Loan product deleted successfully!', 'success')
        },
        onError: (errors) => {
            showToast(errors.error || 'Failed to delete loan product', 'error')
        }
    })
}

const closeModal = () => {
    showCreateModal.value = false
    selectedProduct.value = null
}

const handleSaved = (message) => {
    closeModal()
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
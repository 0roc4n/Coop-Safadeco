<template>
    <Head title="Account Codes" />
    <AppLayout>
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chart of Accounts
        </h2>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md rounded-lg">
                    <!-- Search and Filters -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4">
                            <div class="flex-1 flex items-center space-x-2">
                                <div class="relative flex-1">
                                    <input
                                        v-model="search"
                                        type="text"
                                        placeholder="Search accounts..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        @keyup.enter="performSearch"
                                    />
                                    <div class="absolute left-3 top-2.5 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-40">
                                    <select
                                        v-model="typeFilter"
                                        class="w-full py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        @change="performSearch"
                                    >
                                        <option value="">All Types</option>
                                        <option v-for="type in types" :key="type" :value="type">
                                            {{ getTypeName(type) }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <button
                                @click="openAddModal"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Account
                            </button>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    <div v-if="$page.props.flash && $page.props.flash.success" 
                         class="bg-green-50 border-l-4 border-green-400 p-4 m-4 rounded-md" 
                         role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ $page.props.flash.success }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account Code
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sub Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Has SL
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="accountCodes.data.length === 0">
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No account codes found
                                    </td>
                                </tr>
                                <tr v-for="account in accountCodes.data" :key="account.AcctCode" class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ account.AcctCode }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ account.Description || 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ getTypeName(account.Type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ getSubTypeName(account.SubType) || 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span :class="account.HasSL ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            {{ account.HasSL ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button @click="viewAccount(account)" class="text-blue-600 hover:text-blue-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button @click="editAccount(account)" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button @click="confirmDelete(account)" class="text-red-600 hover:text-red-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                    <div class="px-6 py-4 border-t border-gray-200">
                        <Pagination :links="accountCodes.links" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div v-if="showModal" class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="submitForm">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                {{ editMode ? 'Edit Account Code' : 'Add New Account Code' }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Account Code -->
                                <div class="col-span-2" v-if="!editMode">
                                    <label for="acctCode" class="block text-sm font-medium text-gray-700">Account Code*</label>
                                    <input
                                        type="text"
                                        id="acctCode"
                                        v-model="form.AcctCode"
                                        maxlength="12"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required
                                    />
                                    <div v-if="form.errors.AcctCode" class="text-red-500 text-xs mt-1">{{ form.errors.AcctCode }}</div>
                                </div>

                                <!-- Description -->
                                <div class="col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <input
                                        type="text"
                                        id="description"
                                        v-model="form.Description"
                                        maxlength="64"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    />
                                    <div v-if="form.errors.Description" class="text-red-500 text-xs mt-1">{{ form.errors.Description }}</div>
                                </div>

                                <!-- Type -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Type*</label>
                                    <select
                                        id="type"
                                        v-model="form.Type"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required
                                    >
                                        <option value="" disabled>Select Type</option>
                                        <option value="1">Asset</option>
                                        <option value="2">Liability</option>
                                        <option value="3">Equity</option>
                                        <option value="4">Income</option>
                                        <option value="5">Expense</option>
                                    </select>
                                    <div v-if="form.errors.Type" class="text-red-500 text-xs mt-1">{{ form.errors.Type }}</div>
                                </div>

                                <!-- SubType -->
                                <div>
                                    <label for="subType" class="block text-sm font-medium text-gray-700">Sub Type</label>
                                    <select
                                        id="subType"
                                        v-model="form.SubType"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    >
                                        <option value="">None</option>
                                        <option value="1">Current</option>
                                        <option value="2">Non-Current</option>
                                        <option value="3">Fixed</option>
                                        <option value="4">Operating</option>
                                        <option value="5">Non-Operating</option>
                                    </select>
                                    <div v-if="form.errors.SubType" class="text-red-500 text-xs mt-1">{{ form.errors.SubType }}</div>
                                </div>
                                
                                <!-- AcctType -->
                                <div>
                                    <label for="acctType" class="block text-sm font-medium text-gray-700">Account Type</label>
                                    <select
                                        id="acctType"
                                        v-model="form.AcctType"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    >
                                        <option value="">None</option>
                                        <option value="1">Debit</option>
                                        <option value="2">Credit</option>
                                    </select>
                                    <div v-if="form.errors.AcctType" class="text-red-500 text-xs mt-1">{{ form.errors.AcctType }}</div>
                                </div>

                                <!-- HasSL -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Has SL*</label>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" v-model="form.HasSL" :value="true" class="form-radio h-4 w-4 text-blue-600" required />
                                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" v-model="form.HasSL" :value="false" class="form-radio h-4 w-4 text-blue-600" required />
                                            <span class="ml-2 text-sm text-gray-700">No</span>
                                        </label>
                                    </div>
                                    <div v-if="form.errors.HasSL" class="text-red-500 text-xs mt-1">{{ form.errors.HasSL }}</div>
                                </div>
                                
                                <!-- Related Parent Code -->
                                <div>
                                    <label for="relatedParentCode" class="block text-sm font-medium text-gray-700">Related Parent Code</label>
                                    <input
                                        type="text"
                                        id="relatedParentCode"
                                        v-model="form.RelatedParentCode"
                                        maxlength="12"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    />
                                    <div v-if="form.errors.RelatedParentCode" class="text-red-500 text-xs mt-1">{{ form.errors.RelatedParentCode }}</div>
                                </div>

                                <!-- CodeExt -->
                                <div>
                                    <label for="codeExt" class="block text-sm font-medium text-gray-700">Code Ext*</label>
                                    <input
                                        type="number"
                                        id="codeExt"
                                        v-model="form.CodeExt"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required
                                    />
                                    <div v-if="form.errors.CodeExt" class="text-red-500 text-xs mt-1">{{ form.errors.CodeExt }}</div>
                                </div>
                                
                                <!-- XOverride -->
                                <div>
                                    <label for="xOverride" class="block text-sm font-medium text-gray-700">X Override*</label>
                                    <input
                                        type="number"
                                        id="xOverride"
                                        v-model="form.XOverride"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required
                                    />
                                    <div v-if="form.errors.XOverride" class="text-red-500 text-xs mt-1">{{ form.errors.XOverride }}</div>
                                </div>
                                
                                <!-- AcctClass -->
                                <div>
                                    <label for="acctClass" class="block text-sm font-medium text-gray-700">Account Class</label>
                                    <input
                                        type="number"
                                        id="acctClass"
                                        v-model="form.AcctClass"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    />
                                    <div v-if="form.errors.AcctClass" class="text-red-500 text-xs mt-1">{{ form.errors.AcctClass }}</div>
                                </div>
                                
                                <!-- AccumDepCode -->
                                <div>
                                    <label for="accumDepCode" class="block text-sm font-medium text-gray-700">Accumulated Depreciation Code</label>
                                    <input
                                        type="text"
                                        id="accumDepCode"
                                        v-model="form.AccumDepCode"
                                        maxlength="12"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    />
                                    <div v-if="form.errors.AccumDepCode" class="text-red-500 text-xs mt-1">{{ form.errors.AccumDepCode }}</div>
                                </div>
                                
                                <!-- CashFlowType -->
                                <div>
                                    <label for="cashFlowType" class="block text-sm font-medium text-gray-700">Cash Flow Type*</label>
                                    <input
                                        type="number"
                                        id="cashFlowType"
                                        v-model="form.CashFlowType"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required
                                    />
                                    <div v-if="form.errors.CashFlowType" class="text-red-500 text-xs mt-1">{{ form.errors.CashFlowType }}</div>
                                </div>
                                
                                <!-- IsExpAnalysis -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Is Expense Analysis*</label>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" v-model="form.IsExpAnalysis" :value="true" class="form-radio h-4 w-4 text-blue-600" required />
                                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" v-model="form.IsExpAnalysis" :value="false" class="form-radio h-4 w-4 text-blue-600" required />
                                            <span class="ml-2 text-sm text-gray-700">No</span>
                                        </label>
                                    </div>
                                    <div v-if="form.errors.IsExpAnalysis" class="text-red-500 text-xs mt-1">{{ form.errors.IsExpAnalysis }}</div>
                                </div>
                                
                                <!-- isFinance -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Is Finance</label>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" v-model="form.isFinance" :value="true" class="form-radio h-4 w-4 text-blue-600" />
                                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" v-model="form.isFinance" :value="false" class="form-radio h-4 w-4 text-blue-600" />
                                            <span class="ml-2 text-sm text-gray-700">No</span>
                                        </label>
                                    </div>
                                    <div v-if="form.errors.isFinance" class="text-red-500 text-xs mt-1">{{ form.errors.isFinance }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                                :disabled="form.processing"
                            >
                                {{ editMode ? 'Update' : 'Save' }}
                            </button>
                            <button
                                type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                @click="showModal = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- View Modal -->
        <div v-if="showViewModal" class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showViewModal = false"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Account Code Details
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Account Code:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.AcctCode }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Description:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.Description || 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Type:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ getTypeName(selectedAccount?.Type) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Sub Type:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ getSubTypeName(selectedAccount?.SubType) || 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Account Type:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ getAcctTypeName(selectedAccount?.AcctType) || 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Has SL:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.HasSL ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Related Parent Code:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.RelatedParentCode || 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Code Ext:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.CodeExt }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">X Override:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.XOverride }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Account Class:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.AcctClass || 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Accumulated Depreciation Code:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.AccumDepCode || 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Cash Flow Type:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.CashFlowType }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Is Expense Analysis:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.IsExpAnalysis ? 'Yes' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Is Finance:</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ selectedAccount?.isFinance ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="editAccount(selectedAccount)"
                        >
                            Edit
                        </button>
                        <button
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="showViewModal = false"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showDeleteModal = false"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Account Code
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this account code? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="deleteAccount"
                            :disabled="form.processing"
                        >
                            Delete
                        </button>
                        <button
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="showDeleteModal = false"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';

// Props from the controller
const props = defineProps({
    accountCodes: Object,
    filters: Object,
    types: Array,
});

// State variables
const search = ref(props.filters.search || '');
const typeFilter = ref(props.filters.type || '');
const showModal = ref(false);
const showViewModal = ref(false);
const showDeleteModal = ref(false);
const editMode = ref(false);
const selectedAccount = ref(null);

// Form for adding/editing account codes
const form = useForm({
    AcctCode: '',
    Type: '',
    SubType: '',
    Description: '',
    AcctType: '',
    HasSL: false,
    RelatedParentCode: '',
    CodeExt: 0,
    XOverride: 0,
    AcctClass: '',
    AccumDepCode: '',
    CashFlowType: 0,
    IsExpAnalysis: false,
    isFinance: null,
});

// Type and SubType name mappings
const typeNames = {
    1: 'Asset',
    2: 'Liability',
    3: 'Equity',
    4: 'Income',
    5: 'Expense',
};

const subTypeNames = {
    1: 'Current',
    2: 'Non-Current',
    3: 'Fixed',
    4: 'Operating',
    5: 'Non-Operating',
};

const acctTypeNames = {
    1: 'Debit',
    2: 'Credit',
};

// Get display names for codes
const getTypeName = (type) => typeNames[type] || `Type ${type}`;
const getSubTypeName = (subType) => subTypeNames[subType] || null;
const getAcctTypeName = (acctType) => acctTypeNames[acctType] || null;

// Search handler
const performSearch = () => {
    router.get(route('admin.account-codes.index'), {
        search: search.value || undefined,
        type: typeFilter.value || undefined,
    }, { preserveState: true, replace: true });
};

// Open modal for adding a new account code
const openAddModal = () => {
    editMode.value = false;
    form.reset();
    form.clearErrors();
    showModal.value = true;
};

// View account details
const viewAccount = (account) => {
    selectedAccount.value = account;
    showViewModal.value = true;
};

// Open modal for editing an account
const editAccount = (account) => {
    editMode.value = true;
    selectedAccount.value = account;
    
    form.reset();
    form.clearErrors();
    
    form.AcctCode = account.AcctCode;
    form.Type = account.Type;
    form.SubType = account.SubType || '';
    form.Description = account.Description || '';
    form.AcctType = account.AcctType || '';
    form.HasSL = Boolean(account.HasSL);
    form.RelatedParentCode = account.RelatedParentCode || '';
    form.CodeExt = account.CodeExt;
    form.XOverride = account.XOverride;
    form.AcctClass = account.AcctClass || '';
    form.AccumDepCode = account.AccumDepCode || '';
    form.CashFlowType = account.CashFlowType;
    form.IsExpAnalysis = Boolean(account.IsExpAnalysis);
    form.isFinance = account.isFinance === null ? null : Boolean(account.isFinance);
    
    showViewModal.value = false;
    showModal.value = true;
};

// Submit form for adding or updating an account
const submitForm = () => {
    if (editMode.value) {
        form.put(route('admin.account-codes.update', selectedAccount.value.AcctCode), {
            onSuccess: () => {
                showModal.value = false;
            }
        });
    } else {
        form.post(route('admin.account-codes.store'), {
            onSuccess: () => {
                showModal.value = false;
            }
        });
    }
};

// Confirm delete account
const confirmDelete = (account) => {
    selectedAccount.value = account;
    showDeleteModal.value = true;
};

// Delete account
const deleteAccount = () => {
    form.delete(route('admin.account-codes.destroy', selectedAccount.value.AcctCode), {
        onSuccess: () => {
            showDeleteModal.value = false;
        }
    });
};
</script>
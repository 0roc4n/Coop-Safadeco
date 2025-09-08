<template>
    <DialogModal :show="show" max-width="6xl" @close="$emit('close')">
        <template #title>
            <div class="flex items-center space-x-2">
                <div class="p-2 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <span class="text-lg font-semibold">{{ isEditing ? 'Edit Loan Product' : 'Create New Loan Product' }}</span>
            </div>
        </template>

        <template #content>
            <form @submit.prevent="submitForm" class="space-y-8">
                <!-- Basic Information Section -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Basic Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Loan Code <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.LoanCode"
                                type="text"
                                maxlength="12"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.LoanCode }"
                                placeholder="Enter unique loan code"
                                required
                            >
                            <p v-if="errors.LoanCode" class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                {{ errors.LoanCode }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Loan Type <span class="text-red-500">*</span>
                            </label>
                            <select
                                v-model="form.LoanType"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
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

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.Description"
                                type="text"
                                maxlength="64"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.Description }"
                                placeholder="Enter loan product description"
                                required
                            >
                            <p v-if="errors.Description" class="text-red-500 text-xs mt-1">{{ errors.Description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Interest Rates Section -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Interest Rates & Terms
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Interest Rate (%) <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.InterestRate"
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.InterestRate }"
                                placeholder="0.00"
                                required
                                @input="form.IRate = form.InterestRate"
                            >
                            <p v-if="errors.InterestRate" class="text-red-500 text-xs mt-1">{{ errors.InterestRate }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Min Interest Rate (%)
                            </label>
                            <input
                                v-model="form.MinInterestRate"
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MinInterestRate }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.MinInterestRate" class="text-red-500 text-xs mt-1">{{ errors.MinInterestRate }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Max Interest Rate (%)
                            </label>
                            <input
                                v-model="form.MaxInterestRate"
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MaxInterestRate }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.MaxInterestRate" class="text-red-500 text-xs mt-1">{{ errors.MaxInterestRate }}</p>
                        </div>
                    </div>
                </div>

                <!-- Loan Amounts Section -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Loan Amounts
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Default Loan Amount <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.LoanAmount"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.LoanAmount }"
                                placeholder="0.00"
                                required
                            >
                            <p v-if="errors.LoanAmount" class="text-red-500 text-xs mt-1">{{ errors.LoanAmount }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Loan Amount <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.MinLoanAmount"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MinLoanAmount }"
                                placeholder="0.00"
                                required
                            >
                            <p v-if="errors.MinLoanAmount" class="text-red-500 text-xs mt-1">{{ errors.MinLoanAmount }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Maximum Loan Amount <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.MaxLoanAmount"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MaxLoanAmount }"
                                placeholder="0.00"
                                required
                            >
                            <p v-if="errors.MaxLoanAmount" class="text-red-500 text-xs mt-1">{{ errors.MaxLoanAmount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Terms Section -->
                <div class="bg-yellow-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Loan Terms
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Term (months) <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.MinTerm"
                                type="number"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MinTerm }"
                                placeholder="1"
                                required
                            >
                            <p v-if="errors.MinTerm" class="text-red-500 text-xs mt-1">{{ errors.MinTerm }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Maximum Term (months) <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.MaxTerm"
                                type="number"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MaxTerm }"
                                placeholder="12"
                                required
                            >
                            <p v-if="errors.MaxTerm" class="text-red-500 text-xs mt-1">{{ errors.MaxTerm }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Grace Period (days)
                            </label>
                            <input
                                v-model="form.GracePeriod"
                                type="number"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.GracePeriod }"
                                placeholder="0"
                            >
                            <p v-if="errors.GracePeriod" class="text-red-500 text-xs mt-1">{{ errors.GracePeriod }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Penalty Grace Period (days)
                            </label>
                            <input
                                v-model="form.PenaltyGracePeriod"
                                type="number"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.PenaltyGracePeriod }"
                                placeholder="0"
                            >
                            <p v-if="errors.PenaltyGracePeriod" class="text-red-500 text-xs mt-1">{{ errors.PenaltyGracePeriod }}</p>
                        </div>
                    </div>
                </div>

                <!-- Requirements Section -->
                <div class="bg-red-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Requirements & Options
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input
                                    v-model="form.HasCollateral"
                                    type="checkbox"
                                    class="mr-3 text-green-600 focus:ring-green-500 rounded"
                                >
                                <span class="text-sm font-medium text-gray-700">Requires Collateral</span>
                            </label>

                            <label class="flex items-center">
                                <input
                                    v-model="form.HasCoMaker"
                                    type="checkbox"
                                    class="mr-3 text-green-600 focus:ring-green-500 rounded"
                                >
                                <span class="text-sm font-medium text-gray-700">Requires Co-maker</span>
                            </label>
                        </div>

                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input
                                    v-model="form.FixedRate"
                                    type="checkbox"
                                    class="mr-3 text-green-600 focus:ring-green-500 rounded"
                                >
                                <span class="text-sm font-medium text-gray-700">Fixed Interest Rate</span>
                            </label>

                            <label class="flex items-center">
                                <input
                                    v-model="form.AutoPenalty"
                                    type="checkbox"
                                    class="mr-3 text-green-600 focus:ring-green-500 rounded"
                                >
                                <span class="text-sm font-medium text-gray-700">Auto Penalty</span>
                            </label>
                        </div>

                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input
                                    v-model="form.LoanTerminMaturity"
                                    type="checkbox"
                                    class="mr-3 text-green-600 focus:ring-green-500 rounded"
                                >
                                <span class="text-sm font-medium text-gray-700">Loan Term in Maturity</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Fees Section -->
                <div class="bg-purple-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Fees & Charges
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Service Charge
                            </label>
                            <input
                                v-model="form.ServCharge"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.ServCharge }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.ServCharge" class="text-red-500 text-xs mt-1">{{ errors.ServCharge }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Document Stamp
                            </label>
                            <input
                                v-model="form.DocStamp"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.DocStamp }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.DocStamp" class="text-red-500 text-xs mt-1">{{ errors.DocStamp }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                MRI Fee
                            </label>
                            <input
                                v-model="form.MRI"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.MRI }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.MRI" class="text-red-500 text-xs mt-1">{{ errors.MRI }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Notarial Fee
                            </label>
                            <input
                                v-model="form.NotarialFee"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.NotarialFee }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.NotarialFee" class="text-red-500 text-xs mt-1">{{ errors.NotarialFee }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Filing Fee
                            </label>
                            <input
                                v-model="form.FilingFee"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.FilingFee }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.FilingFee" class="text-red-500 text-xs mt-1">{{ errors.FilingFee }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Penalty Rate (%)
                            </label>
                            <input
                                v-model="form.PenaltyRate"
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                :class="{ 'border-red-500': errors.PenaltyRate }"
                                placeholder="0.00"
                            >
                            <p v-if="errors.PenaltyRate" class="text-red-500 text-xs mt-1">{{ errors.PenaltyRate }}</p>
                        </div>
                    </div>
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
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="processing" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                    <span v-else>{{ isEditing ? 'Update Product' : 'Create Product' }}</span>
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
    product: Object
})

const emit = defineEmits(['close', 'saved'])

// Form data with all the loan product fields
const form = ref({
    LoanCode: '',
    LoanType: '',
    Description: '',
    IRate: '',
    InterestRate: '',
    MinInterestRate: '',
    MaxInterestRate: '',
    LoanAmount: '',
    MinLoanAmount: '',
    MaxLoanAmount: '',
    MinTerm: '',
    MaxTerm: '',
    GracePeriod: '',
    PenaltyGracePeriod: '',
    HasCollateral: false,
    HasCoMaker: false,
    FixedRate: false,
    AutoPenalty: false,
    LoanTerminMaturity: false,
    ServCharge: 0,
    DocStamp: 0,
    MRI: 0,
    NotarialFee: 0,
    FilingFee: 0,
    PenaltyRate: 0,
    // Additional required fields that might be missing
    Compounding: 0,
    LoanTerm: 0,
    TermQty: 0,
    PrincipalMOP: 0,
    InterestMOP: 0,
    PenaltyComp: 0,
    ServChargeType: 0,
    DocStampType: 0,
    MRIType: 0,
    NotarialFeeType: 0,
    FilingFeeType: 0,
    CIBIType: 0,
    AFeesType: 0,
    CBType: 0,
    PrinUseMode: 0,
    IntUseMode: 0,
    SavingsUseMode: 0,
    LoanProdGroup: 0,
    CIBI: 0,
    AFees: 0,
    CBAmount: 0,
    // Savings account type fields
    FSav1: '',
    FSav2: '',
    FSav3: '',
    FSav4: '',
    FSav5: '',
    FSav1Type: 0,
    FSav2Type: 0,
    FSav3Type: 0,
    FSav4Type: 0,
    FSav5Type: 0
})

const errors = ref({})
const processing = ref(false)

const isEditing = computed(() => !!props.product?.LoanCode)

// Watch for product changes (editing)
watch(() => props.product, (newProduct) => {
    if (newProduct) {
        // Populate form with product data for editing
        Object.keys(form.value).forEach(key => {
            if (newProduct[key] !== undefined) {
                form.value[key] = newProduct[key]
            }
        })
    } else {
        // Reset form for new product
        Object.keys(form.value).forEach(key => {
            if (typeof form.value[key] === 'boolean') {
                form.value[key] = false
            } else if (key === 'FSav1' || key === 'FSav2' || key === 'FSav3' || key === 'FSav4' || key === 'FSav5' ||
                      key === 'LoanCode' || key === 'Description' || key === 'PenaltyGL' || 
                      key.startsWith('AcctCode_')) {
                form.value[key] = '' // String fields
            } else {
                form.value[key] = 0 // Numeric fields get 0 default
            }
        })
    }
    errors.value = {}
}, { immediate: true })

// Watch for show changes to reset form
watch(() => props.show, (show) => {
    if (!show) {
        errors.value = {}
        processing.value = false
    }
})

const submitForm = () => {
    processing.value = true
    errors.value = {}

    // Prepare form data with proper types
    const formData = { ...form.value }
    
    // Ensure IRate matches InterestRate if not set
    if (formData.InterestRate && !formData.IRate) {
        formData.IRate = formData.InterestRate
    }
    
    // Convert string numbers to proper types
    if (formData.LoanType) formData.LoanType = parseInt(formData.LoanType)
    if (formData.IRate) formData.IRate = parseFloat(formData.IRate)
    if (formData.InterestRate) formData.InterestRate = parseFloat(formData.InterestRate)
    if (formData.MinInterestRate) formData.MinInterestRate = parseFloat(formData.MinInterestRate)
    if (formData.MaxInterestRate) formData.MaxInterestRate = parseFloat(formData.MaxInterestRate)
    if (formData.LoanAmount) formData.LoanAmount = parseFloat(formData.LoanAmount)
    if (formData.MinLoanAmount) formData.MinLoanAmount = parseFloat(formData.MinLoanAmount)
    if (formData.MaxLoanAmount) formData.MaxLoanAmount = parseFloat(formData.MaxLoanAmount)
    if (formData.MinTerm) formData.MinTerm = parseInt(formData.MinTerm)
    if (formData.MaxTerm) formData.MaxTerm = parseInt(formData.MaxTerm)
    if (formData.GracePeriod) formData.GracePeriod = parseInt(formData.GracePeriod)
    if (formData.PenaltyGracePeriod) formData.PenaltyGracePeriod = parseInt(formData.PenaltyGracePeriod)
    
    // Convert fee fields with default values
    const feeFields = ['ServCharge', 'DocStamp', 'MRI', 'NotarialFee', 'FilingFee', 'PenaltyRate', 'CIBI', 'AFees', 'CBAmount']
    feeFields.forEach(field => {
        if (formData[field] && formData[field] !== '') {
            formData[field] = parseFloat(formData[field])
        } else {
            formData[field] = 0.00 // Set default value for fee fields
        }
    })
    
    // Convert integer fields with default values for required fields
    const integerFields = ['Compounding', 'LoanTerm', 'TermQty', 'PrincipalMOP', 'InterestMOP', 'PenaltyComp', 
                          'ServChargeType', 'DocStampType', 'MRIType', 'NotarialFeeType', 'FilingFeeType', 
                          'CIBIType', 'AFeesType', 'CBType', 'PrinUseMode', 'IntUseMode', 'SavingsUseMode', 'LoanProdGroup']
    integerFields.forEach(field => {
        if (formData[field]) {
            formData[field] = parseInt(formData[field])
        } else {
            formData[field] = 0 // Set default value for required integer fields
        }
    })

    const url = isEditing.value 
        ? route('admin.loan-products.update', props.product.LoanCode)
        : route('admin.loan-products.store')
    
    const method = isEditing.value ? 'put' : 'post'

    console.log('Submitting form data:', formData) // Debug log

    router[method](url, formData, {
        onSuccess: () => {
            processing.value = false
            emit('saved', `Loan product ${isEditing.value ? 'updated' : 'created'} successfully!`)
        },
        onError: (serverErrors) => {
            processing.value = false
            errors.value = serverErrors
            console.error('Form submission errors:', serverErrors) // Debug log
        }
    })
}
</script>

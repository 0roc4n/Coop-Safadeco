<template>
    <DialogModal :show="show" max-width="5xl" @close="$emit('close')">
        <template #title>
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Loan Product Details</h3>
                    <p class="text-sm text-gray-600">{{ product?.LoanCode || 'N/A' }}</p>
                </div>
            </div>
        </template>

        <template #content>
            <div v-if="product" class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Basic Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Loan Code</label>
                                <p class="text-lg font-semibold text-gray-900">{{ product.LoanCode }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Loan Type</label>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full" :class="getLoanTypeClass(product.LoanType)">
                                    {{ getLoanTypeName(product.LoanType) }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Description</label>
                                <p class="text-lg text-gray-900">{{ product.Description }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Created Date</label>
                                <p class="text-sm text-gray-900">{{ formatDate(product.created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interest Rates -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Interest Rates & Terms
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-2xl font-bold text-green-600">{{ formatPercentage(product.InterestRate) }}</div>
                            <div class="text-sm text-gray-600">Standard Rate</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">{{ formatPercentage(product.MinInterestRate) }}</div>
                            <div class="text-sm text-gray-600">Minimum Rate</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">{{ formatPercentage(product.MaxInterestRate) }}</div>
                            <div class="text-sm text-gray-600">Maximum Rate</div>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="product.FixedRate ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'">
                                {{ product.FixedRate ? 'Fixed Rate' : 'Variable Rate' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Loan Amounts -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Loan Amounts
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-2xl font-bold text-purple-600">₱{{ formatCurrency(product.LoanAmount) }}</div>
                            <div class="text-sm text-gray-600">Default Amount</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.MinLoanAmount) }}</div>
                            <div class="text-sm text-gray-600">Minimum Amount</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.MaxLoanAmount) }}</div>
                            <div class="text-sm text-gray-600">Maximum Amount</div>
                        </div>
                    </div>
                </div>

                <!-- Terms & Grace Periods -->
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Terms & Grace Periods
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-xl font-bold text-orange-600">{{ product.MinTerm }}</div>
                            <div class="text-sm text-gray-600">Min Term (months)</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-xl font-bold text-orange-600">{{ product.MaxTerm }}</div>
                            <div class="text-sm text-gray-600">Max Term (months)</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">{{ product.GracePeriod || 0 }}</div>
                            <div class="text-sm text-gray-600">Grace Period (days)</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">{{ product.PenaltyGracePeriod || 0 }}</div>
                            <div class="text-sm text-gray-600">Penalty Grace (days)</div>
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Requirements & Options
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="product.HasCollateral ? 'bg-red-100' : 'bg-green-100'">
                                    <svg v-if="product.HasCollateral" class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <svg v-else class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Collateral</div>
                                <div class="text-xs text-gray-600">{{ product.HasCollateral ? 'Required' : 'Not Required' }}</div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="product.HasCoMaker ? 'bg-yellow-100' : 'bg-green-100'">
                                    <svg v-if="product.HasCoMaker" class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <svg v-else class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Co-maker</div>
                                <div class="text-xs text-gray-600">{{ product.HasCoMaker ? 'Required' : 'Not Required' }}</div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="product.AutoPenalty ? 'bg-red-100' : 'bg-gray-100'">
                                    <svg v-if="product.AutoPenalty" class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <svg v-else class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Auto Penalty</div>
                                <div class="text-xs text-gray-600">{{ product.AutoPenalty ? 'Enabled' : 'Disabled' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fees & Charges -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Fees & Charges
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div v-if="product.ServCharge" class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.ServCharge) }}</div>
                            <div class="text-sm text-gray-600">Service Charge</div>
                        </div>
                        <div v-if="product.DocStamp" class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.DocStamp) }}</div>
                            <div class="text-sm text-gray-600">Document Stamp</div>
                        </div>
                        <div v-if="product.MRI" class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.MRI) }}</div>
                            <div class="text-sm text-gray-600">MRI Fee</div>
                        </div>
                        <div v-if="product.NotarialFee" class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.NotarialFee) }}</div>
                            <div class="text-sm text-gray-600">Notarial Fee</div>
                        </div>
                        <div v-if="product.FilingFee" class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-gray-900">₱{{ formatCurrency(product.FilingFee) }}</div>
                            <div class="text-sm text-gray-600">Filing Fee</div>
                        </div>
                        <div v-if="product.PenaltyRate" class="text-center p-4 bg-white rounded-lg shadow-sm">
                            <div class="text-lg font-semibold text-red-600">{{ formatPercentage(product.PenaltyRate) }}</div>
                            <div class="text-sm text-gray-600">Penalty Rate</div>
                        </div>
                    </div>
                    <div v-if="!hasAnyFees" class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <p>No additional fees configured for this loan product</p>
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
import { computed } from 'vue'
import DialogModal from '@/Components/DialogModal.vue'

const props = defineProps({
    show: Boolean,
    product: Object
})

defineEmits(['close'])

const hasAnyFees = computed(() => {
    if (!props.product) return false
    return !!(props.product.ServCharge || props.product.DocStamp || props.product.MRI || 
             props.product.NotarialFee || props.product.FilingFee || props.product.PenaltyRate)
})

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

const formatDate = (dateString) => {
    if (!dateString) return 'N/A'
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}
</script>

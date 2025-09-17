<script setup>
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import AccountantSidebar from '@/Components/AccountantSidebar.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import DialogModal from '@/Components/DialogModal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const showJournal = ref(false)
const showReconciliation = ref(false)
const showFixedAsset = ref(false)

const journalForm = ref({ date: '', reference: '', debit: '', credit: '', description: '' })
const reconForm = ref({ statementDate: '', bankBalance: '', bookBalance: '' })
const assetForm = ref({ name: '', cost: '', acquisitionDate: '', lifeYears: '' })

const errors = ref({})

function validate(form) {
	const e = {}
	Object.entries(form).forEach(([k, v]) => { if (!v) e[k] = 'Required' })
	return e
}

function submit(which) {
	let form
	if (which === 'journal') form = journalForm.value
	if (which === 'recon') form = reconForm.value
	if (which === 'asset') form = assetForm.value
	const e = validate(form)
	errors.value = e
	if (Object.keys(e).length) return
	// TODO: Replace with real POSTs
	closeAll()
}

function closeAll() {
	showJournal.value = false
	showReconciliation.value = false
	showFixedAsset.value = false
}

// Widgets sample data
const dailyCashBalance = ref(125000)
const pendingRecons = ref(3)
const arSummary = ref({ current: 82000, overdue: 24000 })
const apSummary = ref({ current: 46000, overdue: 12000 })

const quickRatios = ref({ currentRatio: 1.8, quickRatio: 1.3, debtToEquity: 0.6 })

// Simple inline sparkline chart data
const cashFlowSeries = ref([12, 18, 15, 22, 17, 25, 20])
const maxCash = computed(() => Math.max(...cashFlowSeries.value))

function downloadReport(which) {
	// TODO: Link to backend
}
</script>

<template>
    <AppLayout title="Accountant Dashboard">
		<Head title="Accountant Dashboard" />

        <template #sidebar>
            <AccountantSidebar :current="'dashboard'" />
        </template>

		<div class="w-full">
			<!-- Top Bar / Quick Actions -->
			<div class="flex flex-wrap items-center justify-between mb-6 gap-3">
				<div>
					<h1 class="text-2xl font-bold text-gray-800">Accountant Dashboard</h1>
					<p class="text-sm text-gray-500">Professional finance overview with actionable insights</p>
				</div>
				<div class="flex flex-wrap gap-2">
					<PrimaryButton @click="showJournal = true">New Journal Entry</PrimaryButton>
					<SecondaryButton @click="showReconciliation = true">Bank Reconciliation</SecondaryButton>
					<DangerButton @click="showFixedAsset = true">Fixed Asset Entry</DangerButton>
				</div>
			</div>

			<!-- Widgets Row -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Daily Cash Balance</div>
					<div class="text-2xl font-bold text-blue-700">₱{{ dailyCashBalance.toLocaleString() }}</div>
					<!-- sparkline -->
					<svg class="w-full h-12 mt-2" viewBox="0 0 100 30" preserveAspectRatio="none">
						<polyline :points="cashFlowSeries.map((v,i)=>`${i*(100/(cashFlowSeries.length-1))},${30-(v/maxCash*30)}`).join(' ')" fill="none" stroke="#2563eb" stroke-width="2" />
					</svg>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Pending Reconciliations</div>
					<div class="text-2xl font-bold text-amber-600">{{ pendingRecons }}</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Accounts Receivable</div>
					<div class="text-lg"><span class="text-gray-500">Current:</span> <span class="font-semibold">₱{{ arSummary.current.toLocaleString() }}</span></div>
					<div class="text-lg"><span class="text-gray-500">Overdue:</span> <span class="font-semibold text-red-600">₱{{ arSummary.overdue.toLocaleString() }}</span></div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Accounts Payable</div>
					<div class="text-lg"><span class="text-gray-500">Current:</span> <span class="font-semibold">₱{{ apSummary.current.toLocaleString() }}</span></div>
					<div class="text-lg"><span class="text-gray-500">Overdue:</span> <span class="font-semibold text-red-600">₱{{ apSummary.overdue.toLocaleString() }}</span></div>
				</div>
			</div>

			<!-- Quick Ratios -->
			<div class="bg-white rounded-lg shadow p-4 border border-gray-100 mb-6">
				<h2 class="text-lg font-semibold mb-3">Quick Ratios</h2>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
					<div>
						<div class="text-sm text-gray-500">Current Ratio</div>
						<div class="text-2xl font-bold">{{ quickRatios.currentRatio.toFixed(2) }}</div>
					</div>
					<div>
						<div class="text-sm text-gray-500">Quick Ratio</div>
						<div class="text-2xl font-bold">{{ quickRatios.quickRatio.toFixed(2) }}</div>
					</div>
					<div>
						<div class="text-sm text-gray-500">Debt to Equity</div>
						<div class="text-2xl font-bold">{{ quickRatios.debtToEquity.toFixed(2) }}</div>
					</div>
				</div>
			</div>

			<!-- Main Panels -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Accounting Entries</h2>
						<div class="flex gap-2">
							<PrimaryButton @click="showJournal = true">Cash Receipt</PrimaryButton>
							<SecondaryButton @click="showJournal = true">Cash Disbursement</SecondaryButton>
							<DangerButton @click="showJournal = true">Non-cash Entry</DangerButton>
						</div>
					</div>
					<div class="text-sm text-gray-500">Record journal entries for receipts, disbursements, and adjustments.</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Fixed Assets</h2>
						<PrimaryButton @click="showFixedAsset = true">Add Asset</PrimaryButton>
					</div>
					<div class="text-sm text-gray-500">Maintain assets, depreciation schedules, and disposals.</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Bank Reconciliation</h2>
						<SecondaryButton @click="showReconciliation = true">Start Reconciliation</SecondaryButton>
					</div>
					<div class="text-sm text-gray-500">Compare system ledger against bank statements and reconcile discrepancies.</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-2">Reports</div>
					<div class="space-y-2">
						<SecondaryButton class="w-full" @click="downloadReport('trial-balance')">Trial Balance</SecondaryButton>
						<SecondaryButton class="w-full" @click="downloadReport('balance-sheet')">Balance Sheet</SecondaryButton>
						<SecondaryButton class="w-full" @click="downloadReport('income-statement')">Income Statement</SecondaryButton>
						<SecondaryButton class="w-full" @click="downloadReport('cash-flow')">Cash Flow Statement</SecondaryButton>
						<SecondaryButton class="w-full" @click="downloadReport('expense-analysis')">Expense Analysis Report</SecondaryButton>
					</div>
				</div>
			</div>
		</div>

		<!-- Modals -->
		<DialogModal :show="showJournal" @close="showJournal = false">
			<template #title>New Journal Entry</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div>
						<InputLabel value="Date" />
						<TextInput v-model="journalForm.date" type="date" class="w-full" />
						<InputError :message="errors.date" />
					</div>
					<div>
						<InputLabel value="Reference" />
						<TextInput v-model="journalForm.reference" class="w-full" />
						<InputError :message="errors.reference" />
					</div>
					<div>
						<InputLabel value="Debit" />
						<TextInput v-model="journalForm.debit" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.debit" />
					</div>
					<div>
						<InputLabel value="Credit" />
						<TextInput v-model="journalForm.credit" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.credit" />
					</div>
					<div class="md:col-span-2">
						<InputLabel value="Description" />
						<TextInput v-model="journalForm.description" class="w-full" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showJournal = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('journal')">Save Entry</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showReconciliation" @close="showReconciliation = false">
			<template #title>Bank Reconciliation</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
					<div>
						<InputLabel value="Statement Date" />
						<TextInput v-model="reconForm.statementDate" type="date" class="w-full" />
						<InputError :message="errors.statementDate" />
					</div>
					<div>
						<InputLabel value="Bank Balance" />
						<TextInput v-model="reconForm.bankBalance" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.bankBalance" />
					</div>
					<div>
						<InputLabel value="Book Balance" />
						<TextInput v-model="reconForm.bookBalance" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.bookBalance" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showReconciliation = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('recon')">Start</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showFixedAsset" @close="showFixedAsset = false">
			<template #title>Fixed Asset Entry</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div>
						<InputLabel value="Asset Name" />
						<TextInput v-model="assetForm.name" class="w-full" />
						<InputError :message="errors.name" />
					</div>
					<div>
						<InputLabel value="Cost" />
						<TextInput v-model="assetForm.cost" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.cost" />
					</div>
					<div>
						<InputLabel value="Acquisition Date" />
						<TextInput v-model="assetForm.acquisitionDate" type="date" class="w-full" />
						<InputError :message="errors.acquisitionDate" />
					</div>
					<div>
						<InputLabel value="Useful Life (years)" />
						<TextInput v-model="assetForm.lifeYears" type="number" step="1" class="w-full" />
						<InputError :message="errors.lifeYears" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showFixedAsset = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('asset')">Save Asset</PrimaryButton>
			</template>
		</DialogModal>
	</AppLayout>
</template>



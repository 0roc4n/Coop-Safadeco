<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import LoanOfficerSidebar from '@/Components/LoanOfficerSidebar.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import DialogModal from '@/Components/DialogModal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const showNewLoan = ref(false)
const showApproveLoan = ref(false)
const showReleaseLoan = ref(false)

const newLoanForm = ref({ memberCode: '', product: '', amount: '', termMonths: '' })
const approveForm = ref({ applicationId: '' })
const releaseForm = ref({ loanId: '', amount: '' })
const errors = ref({})

function validate(form) {
	const e = {}
	Object.entries(form).forEach(([k, v]) => { if (!v) e[k] = 'Required' })
	return e
}

function submit(which) {
	let form
	if (which === 'new') form = newLoanForm.value
	if (which === 'approve') form = approveForm.value
	if (which === 'release') form = releaseForm.value
	const e = validate(form)
	errors.value = e
	if (Object.keys(e).length) return
	closeAll()
}

function closeAll() {
	showNewLoan.value = false
	showApproveLoan.value = false
	showReleaseLoan.value = false
}

// Widgets sample data
const pendingApplications = ref(12)
const activeLoans = ref({ total: 340, overdue: 28, writtenOff: 4 })
const par = ref(3.4) // percent
const releasesToday = ref(7)

const statuses = [
	{ label: 'Active', color: 'bg-green-100 text-green-700', value: activeLoans.value.total - activeLoans.value.overdue - activeLoans.value.writtenOff },
	{ label: 'Overdue', color: 'bg-amber-100 text-amber-700', value: activeLoans.value.overdue },
	{ label: 'Written-off', color: 'bg-red-100 text-red-700', value: activeLoans.value.writtenOff },
]

function downloadReport(which) {
	// TODO: Wire to backend endpoints
}
</script>

<template>
    <AppLayout title="Loan Officer Dashboard">
		<Head title="Loan Officer Dashboard" />

        <template #sidebar>
            <LoanOfficerSidebar :current="'dashboard'" />
        </template>

		<div class="w-full">
			<!-- Top Bar / Quick Actions -->
			<div class="flex flex-wrap items-center justify-between mb-6 gap-3">
				<div>
					<h1 class="text-2xl font-bold text-gray-800">Loan Officer Dashboard</h1>
					<p class="text-sm text-gray-500">Manage loan lifecycle with clear workflows</p>
				</div>
				<div class="flex flex-wrap gap-2">
					<PrimaryButton @click="showNewLoan = true">New Loan Application</PrimaryButton>
					<SecondaryButton @click="showApproveLoan = true">Approve Loan</SecondaryButton>
					<DangerButton @click="showReleaseLoan = true">Release Loan</DangerButton>
				</div>
			</div>

			<!-- Widgets Row -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Pending Loan Applications</div>
					<div class="text-2xl font-bold text-blue-700">{{ pendingApplications }}</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-1">Active Loans</div>
					<div class="flex items-center gap-2">
						<span class="px-2 py-0.5 rounded text-xs" :class="statuses[0].color">Active: {{ statuses[0].value }}</span>
						<span class="px-2 py-0.5 rounded text-xs" :class="statuses[1].color">Overdue: {{ statuses[1].value }}</span>
						<span class="px-2 py-0.5 rounded text-xs" :class="statuses[2].color">Written-off: {{ statuses[2].value }}</span>
					</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Portfolio at Risk (PAR)</div>
					<div class="text-2xl font-bold" :class="par > 5 ? 'text-red-600' : 'text-green-700'">{{ par.toFixed(1) }}%</div>
					<div class="w-full bg-gray-200 rounded h-2 mt-2">
						<div class="h-2 rounded" :class="par > 5 ? 'bg-red-500' : 'bg-green-500'" :style="`width: ${Math.min(par,100)}%`"></div>
					</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Total Releases Today</div>
					<div class="text-2xl font-bold text-emerald-700">{{ releasesToday }}</div>
				</div>
			</div>

			<!-- Main Panels -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Loan Processing</h2>
						<div class="flex gap-2">
							<PrimaryButton @click="showNewLoan = true">Intake</PrimaryButton>
							<SecondaryButton @click="showApproveLoan = true">Approval</SecondaryButton>
							<DangerButton @click="showReleaseLoan = true">Releasing</DangerButton>
						</div>
					</div>
					<div class="text-sm text-gray-500">Handle application intake, approvals, releases, restructuring, and write-offs.</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Loan Monitoring</h2>
						<SecondaryButton>View Aging</SecondaryButton>
					</div>
					<div class="text-sm text-gray-500">Track receivables aging, arrears, and co-maker exposures.</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Reports</h2>
					</div>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
						<SecondaryButton @click="downloadReport('amortization')">Loan Amortization Schedules</SecondaryButton>
						<SecondaryButton @click="downloadReport('releases')">Loan Releases Summary</SecondaryButton>
						<SecondaryButton @click="downloadReport('collection-sheets')">Collection Sheets</SecondaryButton>
						<SecondaryButton @click="downloadReport('loan-analysis')">Loan Analysis Report</SecondaryButton>
					</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-2">Status Overview</div>
					<div class="space-y-2">
						<div v-for="s in statuses" :key="s.label" class="flex items-center justify-between">
							<span class="text-sm">{{ s.label }}</span>
							<span class="px-2 py-0.5 rounded text-xs" :class="s.color">{{ s.value }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modals -->
		<DialogModal :show="showNewLoan" @close="showNewLoan = false">
			<template #title>New Loan Application</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div>
						<InputLabel value="Member Code" />
						<TextInput v-model="newLoanForm.memberCode" class="w-full" />
						<InputError :message="errors.memberCode" />
					</div>
					<div>
						<InputLabel value="Product" />
						<TextInput v-model="newLoanForm.product" class="w-full" />
						<InputError :message="errors.product" />
					</div>
					<div>
						<InputLabel value="Amount" />
						<TextInput v-model="newLoanForm.amount" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.amount" />
					</div>
					<div>
						<InputLabel value="Term (months)" />
						<TextInput v-model="newLoanForm.termMonths" type="number" step="1" class="w-full" />
						<InputError :message="errors.termMonths" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showNewLoan = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('new')">Submit Application</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showApproveLoan" @close="showApproveLoan = false">
			<template #title>Approve Loan</template>
			<template #content>
				<div class="space-y-3">
					<div>
						<InputLabel value="Application ID" />
						<TextInput v-model="approveForm.applicationId" class="w-full" />
						<InputError :message="errors.applicationId" />
					</div>
					<div class="text-sm text-gray-500">Confirm approval of the selected application.</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showApproveLoan = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('approve')">Approve</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showReleaseLoan" @close="showReleaseLoan = false">
			<template #title>Release Loan</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div>
						<InputLabel value="Loan ID" />
						<TextInput v-model="releaseForm.loanId" class="w-full" />
						<InputError :message="errors.loanId" />
					</div>
					<div>
						<InputLabel value="Release Amount" />
						<TextInput v-model="releaseForm.amount" type="number" step="0.01" class="w-full" />
						<InputError :message="errors.amount" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showReleaseLoan = false">Cancel</SecondaryButton>
				<DangerButton @click="submit('release')">Release</DangerButton>
			</template>
		</DialogModal>
	</AppLayout>
</template>



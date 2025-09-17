<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import TellerSidebar from '@/Components/TellerSidebar.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import DialogModal from '@/Components/DialogModal.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const showDeposit = ref(false)
const showWithdrawal = ref(false)
const showLoanCollection = ref(false)
const showDisbursement = ref(false)

const depositForm = ref({ memberCode: '', amount: '', accountType: 'savings' })
const withdrawalForm = ref({ memberCode: '', amount: '', accountType: 'savings' })
const loanCollectionForm = ref({ reference: '', amount: '', group: false })
const disbursementForm = ref({ reference: '', amount: '' })

const errors = ref({})

function validate(form) {
	const e = {}
	Object.entries(form).forEach(([k, v]) => {
		if (v === '' || v === null) e[k] = 'Required'
	})
	return e
}

function submit(type) {
	let form
	if (type === 'deposit') form = depositForm.value
	if (type === 'withdrawal') form = withdrawalForm.value
	if (type === 'loan') form = loanCollectionForm.value
	if (type === 'disbursement') form = disbursementForm.value
	const e = validate(form)
	errors.value = e
	if (Object.keys(e).length) return
	// TODO: Replace with real POST via Inertia router.post to backend
	closeAll()
}

function closeAll() {
	showDeposit.value = false
	showWithdrawal.value = false
	showLoanCollection.value = false
	showDisbursement.value = false
}

const searchTerm = ref('')
const pending = ref([
	{ id: 1, type: 'Withdrawal', member: 'M-1023', amount: 1500 },
	{ id: 2, type: 'Deposit', member: 'M-2044', amount: 800 },
])

const cashPosition = ref({ starting: 10000, collected: 3200, disbursed: 1800 })
const endingBalance = () => cashPosition.value.starting + cashPosition.value.collected - cashPosition.value.disbursed

const collectionsToday = ref({ loans: 2200, deposits: 1000, timeDeposits: 500 })

function downloadReport(which) {
	// TODO: Link to backend report endpoints
}
</script>

<template>
    <AppLayout title="Teller Dashboard">
		<Head title="Teller Dashboard" />

        <template #sidebar>
            <TellerSidebar :current="'dashboard'" />
        </template>

        <div class="w-full">
			<!-- Top Bar / Quick Actions -->
			<div class="flex flex-wrap gap-3 items-center justify-between mb-6">
				<div>
					<h1 class="text-2xl font-bold text-gray-800">Teller Dashboard</h1>
					<p class="text-sm text-gray-500">Fast transactions with a clean, minimal UI</p>
				</div>
				<div class="flex flex-wrap gap-2">
					<PrimaryButton @click="showDeposit = true">New Deposit</PrimaryButton>
					<SecondaryButton @click="showWithdrawal = true">New Withdrawal</SecondaryButton>
					<PrimaryButton @click="showLoanCollection = true">Loan Collection</PrimaryButton>
					<DangerButton @click="showDisbursement = true">Cash Disbursement</DangerButton>
				</div>
			</div>

			<!-- Dashboard Widgets -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-1">Today's Collections</div>
					<div class="flex justify-between">
						<div class="text-center">
							<div class="text-gray-400 text-xs">Loans</div>
							<div class="text-xl font-semibold text-blue-700">₱{{ collectionsToday.loans.toLocaleString() }}</div>
						</div>
						<div class="text-center">
							<div class="text-gray-400 text-xs">Deposits</div>
							<div class="text-xl font-semibold text-green-700">₱{{ collectionsToday.deposits.toLocaleString() }}</div>
						</div>
						<div class="text-center">
							<div class="text-gray-400 text-xs">Time Dep.</div>
							<div class="text-xl font-semibold text-amber-600">₱{{ collectionsToday.timeDeposits.toLocaleString() }}</div>
						</div>
					</div>
				</div>

				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-2">Pending Withdrawals/Deposits</div>
					<div class="space-y-2 max-h-40 overflow-auto">
						<div v-for="item in pending" :key="item.id" class="flex justify-between text-sm">
							<div>
								<span :class="item.type === 'Deposit' ? 'text-green-600' : 'text-red-600'" class="font-medium">{{ item.type }}</span>
								<span class="text-gray-500 ms-2">{{ item.member }}</span>
							</div>
							<div class="font-semibold">₱{{ item.amount.toLocaleString() }}</div>
						</div>
					</div>
				</div>

				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-1">Teller's Cash Position</div>
					<div class="space-y-1 text-sm">
						<div class="flex justify-between"><span class="text-gray-500">Starting</span><span class="font-semibold">₱{{ cashPosition.starting.toLocaleString() }}</span></div>
						<div class="flex justify-between"><span class="text-gray-500">Collected</span><span class="font-semibold text-green-700">₱{{ cashPosition.collected.toLocaleString() }}</span></div>
						<div class="flex justify-between"><span class="text-gray-500">Disbursed</span><span class="font-semibold text-red-600">₱{{ cashPosition.disbursed.toLocaleString() }}</span></div>
						<div class="border-t pt-1 flex justify-between"><span class="text-gray-700 font-medium">Ending</span><span class="font-bold">₱{{ endingBalance().toLocaleString() }}</span></div>
					</div>
				</div>
			</div>

			<!-- Main Panels -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<!-- Savings & Deposits -->
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Savings & Deposits</h2>
						<div class="flex gap-2">
							<PrimaryButton @click="showDeposit = true">Post Deposit</PrimaryButton>
							<SecondaryButton @click="showWithdrawal = true">Post Withdrawal</SecondaryButton>
						</div>
					</div>
					<div class="flex gap-2 mb-3">
						<TextInput v-model="searchTerm" class="w-full" placeholder="Search member name or code..." />
						<SecondaryButton>Search</SecondaryButton>
					</div>
					<div class="text-sm text-gray-500">Use quick actions to record savings, withdrawals, and time deposit transactions.</div>
				</div>

				<!-- Loan Collections -->
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Loan Collections</h2>
						<PrimaryButton @click="showLoanCollection = true">Enter Payment</PrimaryButton>
					</div>
					<div class="text-sm text-gray-500">Record individual payments or group collections.</div>
				</div>
			</div>

			<!-- Cash Management and Reports -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Cash Management</h2>
						<div class="flex gap-2">
							<PrimaryButton @click="showDeposit = true">Cash Receipt</PrimaryButton>
							<DangerButton @click="showDisbursement = true">Cash Disbursement</DangerButton>
						</div>
					</div>
					<div class="text-sm text-gray-500">Manage incoming and outgoing cash from the teller drawer.</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-2">Reports</div>
					<div class="space-y-2">
						<SecondaryButton class="w-full" @click="downloadReport('transactions')">Daily Cash Transaction (per teller)</SecondaryButton>
						<SecondaryButton class="w-full" @click="downloadReport('position')">Daily Cash Position</SecondaryButton>
					</div>
				</div>
			</div>
		</div>

		<!-- Modals -->
		<DialogModal :show="showDeposit" @close="showDeposit = false">
			<template #title>New Deposit</template>
			<template #content>
				<div class="space-y-3">
					<div>
						<InputLabel value="Member Code" />
						<TextInput v-model="depositForm.memberCode" class="w-full" />
						<InputError :message="errors.memberCode" />
					</div>
					<div>
						<InputLabel value="Amount" />
						<TextInput v-model="depositForm.amount" type="number" min="0" step="0.01" class="w-full" />
						<InputError :message="errors.amount" />
					</div>
					<div>
						<InputLabel value="Account Type" />
						<select v-model="depositForm.accountType" class="mt-1 block w-full rounded-md border-gray-300">
							<option value="savings">Savings</option>
							<option value="time">Time Deposit</option>
						</select>
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showDeposit = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('deposit')">Confirm</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showWithdrawal" @close="showWithdrawal = false">
			<template #title>New Withdrawal</template>
			<template #content>
				<div class="space-y-3">
					<div>
						<InputLabel value="Member Code" />
						<TextInput v-model="withdrawalForm.memberCode" class="w-full" />
						<InputError :message="errors.memberCode" />
					</div>
					<div>
						<InputLabel value="Amount" />
						<TextInput v-model="withdrawalForm.amount" type="number" min="0" step="0.01" class="w-full" />
						<InputError :message="errors.amount" />
					</div>
					<div>
						<InputLabel value="Account Type" />
						<select v-model="withdrawalForm.accountType" class="mt-1 block w-full rounded-md border-gray-300">
							<option value="savings">Savings</option>
							<option value="time">Time Deposit</option>
						</select>
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showWithdrawal = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('withdrawal')">Confirm</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showLoanCollection" @close="showLoanCollection = false">
			<template #title>Loan Collection</template>
			<template #content>
				<div class="space-y-3">
					<div>
						<InputLabel value="Reference / Member Code" />
						<TextInput v-model="loanCollectionForm.reference" class="w-full" />
						<InputError :message="errors.reference" />
					</div>
					<div>
						<InputLabel value="Amount" />
						<TextInput v-model="loanCollectionForm.amount" type="number" min="0" step="0.01" class="w-full" />
						<InputError :message="errors.amount" />
					</div>
					<div class="flex items-center gap-2">
						<input id="group" type="checkbox" v-model="loanCollectionForm.group" class="rounded border-gray-300" />
						<label for="group" class="text-sm text-gray-600">Group Collection</label>
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showLoanCollection = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('loan')">Confirm</PrimaryButton>
			</template>
		</DialogModal>

		<ConfirmationModal :show="showDisbursement" @close="showDisbursement = false">
			<template #title>Cash Disbursement</template>
			<template #content>
				<div class="space-y-3">
					<div>
						<InputLabel value="Reference" />
						<TextInput v-model="disbursementForm.reference" class="w-full" />
						<InputError :message="errors.reference" />
					</div>
					<div>
						<InputLabel value="Amount" />
						<TextInput v-model="disbursementForm.amount" type="number" min="0" step="0.01" class="w-full" />
						<InputError :message="errors.amount" />
					</div>
					<div class="text-sm text-gray-500">Confirm to proceed with cash disbursement.</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showDisbursement = false">Cancel</SecondaryButton>
				<DangerButton @click="submit('disbursement')">Confirm Disbursement</DangerButton>
			</template>
		</ConfirmationModal>
	</AppLayout>
</template>



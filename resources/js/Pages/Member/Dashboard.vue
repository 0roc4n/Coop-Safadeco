<script setup>
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import MemberSidebar from '@/Components/MemberSidebar.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const dark = ref(false)

function toggleDark() {
	dark.value = !dark.value
	const root = document.documentElement
	if (dark.value) root.classList.add('dark')
	else root.classList.remove('dark')
}

// Sample user and account data (replace with server props later)
const user = ref({ name: 'Member Name', photo: 'https://via.placeholder.com/64' })
const balances = ref({ savings: 45230.55, shareCapital: 15000.00, loanOutstanding: 12340.00, arrears: 1200.00, timeDeposits: 30000.00 })

const savingsTxns = ref([
	{ id: 1, type: 'Deposit', amount: 1500, date: '2025-09-10' },
	{ id: 2, type: 'Withdrawal', amount: 500, date: '2025-09-12' },
])

const timeDeposits = ref([
	{ id: 'TD-1001', amount: 20000, maturity: '2026-01-10', interest: 1200 },
	{ id: 'TD-1002', amount: 10000, maturity: '2026-06-15', interest: 600 },
])

const shareCapital = ref({ balance: 15000, dividends: 1350 })

const loans = ref([
	{ id: 'LN-2001', type: 'Salary Loan', balance: 8200, status: 'active' },
	{ id: 'LN-2002', type: 'Emergency Loan', balance: 4140, status: 'overdue' },
])

const applications = ref([
	{ id: 'APP-3001', product: 'Salary Loan', status: 'Under Review' },
	{ id: 'APP-3002', product: 'Appliance Loan', status: 'Applied' },
])

const payments = ref([
	{ id: 1, date: '2025-08-30', amount: 1200, status: 'completed' },
	{ id: 2, date: '2025-09-15', amount: 1200, status: 'pending' },
])

const notifications = ref([
	{ id: 1, type: 'due', text: 'Loan LN-2002 due tomorrow', color: 'text-amber-600' },
	{ id: 2, type: 'overdue', text: 'Loan LN-2002 payment overdue', color: 'text-red-600' },
	{ id: 3, type: 'credit', text: 'Dividends posted to Share Capital', color: 'text-green-700' },
])

// Simple inline chart points for balances (sparkline)
const savingsTrend = ref([40, 42, 41, 43, 44, 45])
const loanTrend = ref([14, 13, 12.6, 12.4, 12.3, 12.34])
const maxSavings = computed(() => Math.max(...savingsTrend.value))
const maxLoan = computed(() => Math.max(...loanTrend.value))

function download(which) {
	// TODO: connect to backend download routes
}
</script>

<template>
    <AppLayout title="Member Dashboard">
		<Head title="Member Dashboard" />
        <template #sidebar>
            <MemberSidebar :current="'dashboard'" />
        </template>
        <div class="w-full" :class="{ 'dark': dark }">
			<!-- Top bar -->
			<div class="flex flex-wrap items-center justify-between mb-6 gap-3">
				<div class="flex items-center gap-3">
					<img :src="user.photo" class="size-12 rounded-full object-cover" alt="profile">
					<div>
						<div class="text-xl font-semibold text-gray-800 dark:text-gray-100">Welcome, {{ user.name }}</div>
						<div class="text-sm text-gray-500 dark:text-gray-400">Your cooperative accounts at a glance</div>
					</div>
				</div>
				<div class="flex items-center gap-2">
					<SecondaryButton @click="toggleDark">Toggle Dark Mode</SecondaryButton>
				</div>
			</div>

			<!-- Summary Cards -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700">
					<div class="text-sm text-gray-500 dark:text-gray-400">Total Savings</div>
					<div class="text-2xl font-bold text-green-700">₱{{ balances.savings.toLocaleString(undefined,{maximumFractionDigits:2}) }}</div>
					<svg class="w-full h-10 mt-2" viewBox="0 0 100 24" preserveAspectRatio="none">
						<polyline :points="savingsTrend.map((v,i)=>`${i*(100/(savingsTrend.length-1))},${24-(v/maxSavings*24)}`).join(' ')" fill="none" stroke="#16a34a" stroke-width="2" />
					</svg>
				</div>
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700">
					<div class="text-sm text-gray-500 dark:text-gray-400">Share Capital</div>
					<div class="text-2xl font-bold text-emerald-700">₱{{ balances.shareCapital.toLocaleString() }}</div>
				</div>
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700">
					<div class="text-sm text-gray-500 dark:text-gray-400">Outstanding Loan</div>
					<div class="text-2xl font-bold" :class="balances.arrears>0 ? 'text-red-600':'text-blue-700'">₱{{ balances.loanOutstanding.toLocaleString() }}</div>
					<div class="text-xs" v-if="balances.arrears>0"><span class="text-red-600 font-semibold">Arrears:</span> ₱{{ balances.arrears.toLocaleString() }}</div>
					<svg class="w-full h-10 mt-2" viewBox="0 0 100 24" preserveAspectRatio="none">
						<polyline :points="loanTrend.map((v,i)=>`${i*(100/(loanTrend.length-1))},${24-(v/maxLoan*24)}`).join(' ')" fill="none" stroke="#ef4444" stroke-width="2" />
					</svg>
				</div>
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700">
					<div class="text-sm text-gray-500 dark:text-gray-400">Time Deposits</div>
					<div class="text-2xl font-bold text-blue-700">₱{{ balances.timeDeposits.toLocaleString() }}</div>
				</div>
			</div>

			<!-- Navigation (could map to tabs/sections) -->
			<div class="flex flex-wrap gap-3 mb-4 text-sm">
				<span class="px-3 py-1 rounded bg-blue-50 text-blue-700">Dashboard</span>
				<span class="px-3 py-1 rounded bg-green-50 text-green-700">My Accounts</span>
				<span class="px-3 py-1 rounded bg-amber-50 text-amber-700">My Loans</span>
				<span class="px-3 py-1 rounded bg-slate-50 text-slate-700">Reports</span>
				<span class="px-3 py-1 rounded bg-purple-50 text-purple-700">Notifications</span>
			</div>

			<!-- My Accounts -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700 lg:col-span-2">
					<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Savings Accounts</h2>
					<table class="w-full text-sm">
						<thead class="text-gray-500 dark:text-gray-400">
							<tr><th class="text-left py-2">Date</th><th class="text-left">Type</th><th class="text-right">Amount</th></tr>
						</thead>
						<tbody>
							<tr v-for="t in savingsTxns" :key="t.id" class="border-t border-gray-100 dark:border-gray-700">
								<td class="py-2 text-gray-700 dark:text-gray-200">{{ t.date }}</td>
								<td :class="t.type==='Deposit' ? 'text-green-700' : 'text-red-600'">{{ t.type }}</td>
								<td class="text-right text-gray-800 dark:text-gray-100">₱{{ t.amount.toLocaleString() }}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700">
					<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Time Deposits</h2>
					<ul class="space-y-2 text-sm">
						<li v-for="td in timeDeposits" :key="td.id" class="flex justify-between">
							<span class="text-gray-700 dark:text-gray-200">{{ td.id }} (mat: {{ td.maturity }})</span>
							<span class="text-gray-800 dark:text-gray-100">₱{{ td.amount.toLocaleString() }}</span>
						</li>
					</ul>
					<div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Interest earned: ₱{{ timeDeposits.reduce((s,a)=>s+a.interest,0).toLocaleString() }}</div>
				</div>
			</div>

			<!-- My Loans -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700 lg:col-span-2">
					<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Active Loans</h2>
					<div class="space-y-2">
						<div v-for="ln in loans" :key="ln.id" class="flex items-center justify-between text-sm">
							<div class="text-gray-700 dark:text-gray-200">{{ ln.type }} ({{ ln.id }})</div>
							<div class="font-semibold" :class="ln.status==='overdue' ? 'text-red-600' : 'text-green-700'">₱{{ ln.balance.toLocaleString() }}</div>
						</div>
					</div>
				</div>
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700">
					<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Payment History</h2>
					<ul class="space-y-2 text-sm">
						<li v-for="p in payments" :key="p.id" class="flex items-center justify-between">
							<span class="text-gray-700 dark:text-gray-200">{{ p.date }}</span>
							<span :class="p.status==='completed' ? 'text-green-700' : 'text-amber-600'">{{ p.status }}</span>
							<span class="text-gray-800 dark:text-gray-100">₱{{ p.amount.toLocaleString() }}</span>
						</li>
					</ul>
				</div>
			</div>

			<!-- Applications Tracker -->
			<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700 mt-6">
				<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Loan Applications</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div v-for="a in applications" :key="a.id" class="p-3 rounded border text-sm" :class="a.status==='Approved' ? 'border-green-300' : (a.status==='Under Review' ? 'border-amber-300' : 'border-slate-200 dark:border-slate-600')">
						<div class="font-medium text-gray-800 dark:text-gray-100">{{ a.product }} ({{ a.id }})</div>
						<div class="text-gray-600 dark:text-gray-300">Status: <span :class="a.status==='Approved' ? 'text-green-700' : (a.status==='Under Review' ? 'text-amber-600' : 'text-slate-700')">{{ a.status }}</span></div>
					</div>
				</div>
			</div>

			<!-- Reports -->
			<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700 mt-6">
				<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Reports</h2>
				<div class="flex flex-wrap gap-2">
					<SecondaryButton @click="download('soa')">Statement of Account</SecondaryButton>
					<SecondaryButton @click="download('amort')">Amortization Schedule</SecondaryButton>
					<SecondaryButton @click="download('dividends')">Dividends & Patronage Refund</SecondaryButton>
				</div>
			</div>

			<!-- Notifications -->
			<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-700 mt-6">
				<h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Notifications</h2>
				<ul class="space-y-2 text-sm">
					<li v-for="n in notifications" :key="n.id" class="flex items-center gap-2">
						<span class="size-2 rounded-full" :class="n.type==='overdue' ? 'bg-red-500' : (n.type==='due' ? 'bg-amber-500' : 'bg-green-500')"></span>
						<span :class="n.color">{{ n.text }}</span>
					</li>
				</ul>
			</div>
		</div>
	</AppLayout>
</template>



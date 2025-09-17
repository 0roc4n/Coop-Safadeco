<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { Home, ReceiptText, Banknote, FileText, BookOpenText, Landmark, Calculator, BarChart2, PieChart, Layers3, ChevronLeft, ChevronRight, Sun, Moon, DollarSign } from 'lucide-vue-next'

const props = defineProps({
	collapsedByDefault: { type: Boolean, default: false },
	current: { type: String, default: '' },
})

const collapsed = ref(props.collapsedByDefault)
const mobileOpen = ref(false)
const dark = ref(false)

function toggleCollapse() { collapsed.value = !collapsed.value }
function toggleMobile() { mobileOpen.value = !mobileOpen.value }
function toggleDark() {
	dark.value = !dark.value
	const root = document.documentElement
	if (dark.value) root.classList.add('dark')
	else root.classList.remove('dark')
}

const sections = [
	{
		heading: 'Dashboard',
		items: [
			{ label: 'Dashboard Overview', icon: Home, href: route('accountant.dashboard'), key: 'dashboard' },
			{ label: "Today's Financial Summary", icon: BarChart2, href: route('accountant.dashboard'), key: 'summary' },
			{ label: 'Pending Reconciliations', icon: ReceiptText, href: route('accountant.dashboard'), key: 'pending-recon' },
		],
	},
	{
		heading: 'Accounting Entries',
		items: [
			{ label: 'General Journal', icon: BookOpenText, href: route('accountant.dashboard'), key: 'gj' },
			{ label: 'Cash Receipts Journal', icon: Banknote, href: route('accountant.dashboard'), key: 'crj' },
			{ label: 'Cash Disbursements Journal', icon: DollarSign, href: route('accountant.dashboard'), key: 'cdj' },
		],
	},
	{
		heading: 'Bank Reconciliation',
		items: [
			{ label: 'Match Bank vs System', icon: Landmark, href: route('accountant.dashboard'), key: 'recon' },
		],
	},
	{
		heading: 'Assets',
		items: [
			{ label: 'Add/Track Fixed Assets', icon: Layers3, href: route('accountant.dashboard'), key: 'assets' },
			{ label: 'Depreciation & Disposal', icon: Calculator, href: route('accountant.dashboard'), key: 'depr-disposal' },
		],
	},
	{
		heading: 'Reports',
		items: [
			{ label: 'Trial Balance', icon: FileText, href: route('accountant.dashboard'), key: 'tb' },
			{ label: 'Balance Sheet', icon: PieChart, href: route('accountant.dashboard'), key: 'bs' },
			{ label: 'Income Statement', icon: BarChart2, href: route('accountant.dashboard'), key: 'is' },
			{ label: 'Cash Flow Statement', icon: BarChart2, href: route('accountant.dashboard'), key: 'cf' },
			{ label: 'Receivables & Payables', icon: ReceiptText, href: route('accountant.dashboard'), key: 'arp' },
		],
	},
]

function itemClasses(key) {
	const active = props.current === key
	return [
		'flex items-center gap-3 px-3 py-2 rounded-md transition-colors',
		active
			? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300'
			: 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50',
	]
}
</script>

<template>
	<div v-if="mobileOpen" @click="toggleMobile" class="fixed inset-0 bg-black/20 z-30 lg:hidden" />

	<aside
		:class="[
			'fixed lg:static z-40 h-full lg:h-auto top-0 left-0',
			'bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800',
			'w-64',
			collapsed ? 'lg:w-16' : 'lg:w-64',
			mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
			'transition-all duration-200 ease-in-out'
		]"
		aria-label="Accountant Sidebar"
	>
		<div class="flex items-center justify-between px-3 py-3 border-b border-gray-200 dark:border-gray-800">
			<div class="text-sm font-semibold text-gray-700 dark:text-gray-200" v-if="!collapsed">Accountant</div>
			<div class="flex items-center gap-1">
				<button class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800" @click="toggleDark" :title="dark ? 'Light mode' : 'Dark mode'">
					<Sun v-if="dark" class="size-4 text-amber-400" />
					<Moon v-else class="size-4 text-gray-600 dark:text-gray-300" />
				</button>
				<button class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 hidden lg:block" @click="toggleCollapse" :title="collapsed ? 'Expand' : 'Collapse'">
					<ChevronRight v-if="collapsed" class="size-4 text-gray-600" />
					<ChevronLeft v-else class="size-4 text-gray-600" />
				</button>
				<button class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 lg:hidden" @click="toggleMobile" title="Close">
					<ChevronLeft class="size-4 text-gray-600" />
				</button>
			</div>
		</div>

		<nav class="p-3 space-y-4 overflow-y-auto h-[calc(100vh-48px)]">
			<section v-for="(section, si) in sections" :key="si">
				<h3 v-if="!collapsed" class="px-2 text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1">{{ section.heading }}</h3>
				<ul class="space-y-1">
					<li v-for="item in section.items" :key="item.key">
						<Link :href="item.href" :class="itemClasses(item.key)">
							<component :is="item.icon" class="size-4" />
							<span v-if="!collapsed" class="truncate">{{ item.label }}</span>
						</Link>
					</li>
				</ul>
			</section>
		</nav>
	</aside>

	<button class="lg:hidden fixed bottom-6 left-6 z-30 p-3 rounded-full shadow bg-blue-600 text-white" @click="toggleMobile" aria-label="Open sidebar">
		<ChevronRight class="size-5" />
	</button>
</template>



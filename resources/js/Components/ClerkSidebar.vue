<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { Home, ClipboardList, Users, FileText, Database, Upload, Building2, BadgeCheck, Wallet, Landmark, ChevronLeft, ChevronRight, Sun, Moon } from 'lucide-vue-next'

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
			{ label: 'Dashboard Overview', icon: Home, href: route('clerk.dashboard'), key: 'dashboard' },
			{ label: 'Pending Tasks', icon: ClipboardList, href: route('clerk.dashboard'), key: 'pending' },
		],
	},
	{
		heading: 'Member Management',
		items: [
			{ label: 'Encode New Members', icon: Users, href: route('clerk.clientele.index'), key: 'encode' },
		],
	},
	{
		heading: 'Record Maintenance',
		items: [
			{ label: 'Update Savings Records', icon: Wallet, href: route('clerk.dashboard'), key: 'sav' },
			{ label: 'Update Share Capital Records', icon: Landmark, href: route('clerk.dashboard'), key: 'sc' },
			{ label: 'Update Loan Profiles', icon: FileText, href: route('clerk.dashboard'), key: 'loan-prof' },
		],
	},
	{
		heading: 'Utilities',
		items: [
			{ label: 'Import Initial Balances', icon: Upload, href: route('clerk.dashboard'), key: 'import-bal' },
			{ label: 'Import Departments / Offices / Profiles', icon: Building2, href: route('clerk.dashboard'), key: 'import-master' },
		],
	},
	{
		heading: 'Reports (Basic)',
		items: [
			{ label: 'Masterlist of Members', icon: FileText, href: route('clerk.dashboard'), key: 'rpt-master' },
			{ label: 'Employee / Funder / Creditor Lists', icon: FileText, href: route('clerk.dashboard'), key: 'rpt-lists' },
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
		aria-label="Clerk Sidebar"
	>
		<div class="flex items-center justify-between px-3 py-3 border-b border-gray-200 dark:border-gray-800">
			<div class="text-sm font-semibold text-gray-700 dark:text-gray-200" v-if="!collapsed">Clerk</div>
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



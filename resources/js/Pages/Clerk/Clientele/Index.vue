<script setup>
import { ref, computed, watch } from 'vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ClerkSidebar from '@/Components/ClerkSidebar.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import DialogModal from '@/Components/DialogModal.vue'
import TextInput from '@/Components/TextInput.vue'
import ClientModal from '@/Pages/Admin/Clientele/Components/ClientModal.vue'

const props = defineProps({
	clienteles: Object,
	statistics: Object,
	filters: Object,
})

const search = ref(props.filters?.search || '')
watch(search, (v) => {
	router.get(route('clerk.clientele.index'), { search: v }, { preserveState: true, replace: true })
})

const showClientModal = ref(false)
const isEditingClient = ref(false)
const showDelete = ref(false)
const selected = ref(null)
const selectedClient = ref(null)

function openCreate() {
	isEditingClient.value = false
	selectedClient.value = null
	showClientModal.value = true
}

function openEdit(row) {
	selected.value = row
	selectedClient.value = row
	isEditingClient.value = true
	showClientModal.value = true
}

function openDelete(row) {
	selected.value = row
	showDelete.value = true
}

function handleClientSubmit(payload) {
	if (isEditingClient.value && selected.value) {
		router.put(route('clerk.clientele.update', selected.value.ClientCode), payload, {
			onSuccess: () => { showClientModal.value = false },
		})
	} else {
		router.post(route('clerk.clientele.store'), payload, {
			onSuccess: () => { showClientModal.value = false },
		})
	}
}

function submitDelete() {
	router.delete(route('clerk.clientele.destroy', selected.value.ClientCode), { onSuccess: () => { showDelete.value = false } })
}
</script>

<template>
	<AppLayout title="Clientele">
		<Head title="Clientele" />

		<template #sidebar>
			<ClerkSidebar :current="'encode'" />
		</template>

		<div class="w-full">
			<div class="flex items-center justify-between mb-4">
				<h1 class="text-2xl font-semibold text-gray-800">Clientele</h1>
				<div class="flex gap-2">
					<TextInput v-model="search" placeholder="Search code/name..." />
					<PrimaryButton @click="openCreate">Add Client</PrimaryButton>
				</div>
			</div>

			<!-- Stats -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Total Clients</div>
					<div class="text-2xl font-bold text-blue-700">{{ statistics.total_clients }}</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">New Members (This Month)</div>
					<div class="text-2xl font-bold text-green-700">{{ statistics.new_members_this_month }}</div>
				</div>
			</div>

			<!-- Table -->
			<div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
				<table class="w-full text-sm">
					<thead class="bg-gray-50 text-gray-600">
						<tr>
							<th class="text-left px-4 py-2">Code</th>
							<th class="text-left px-4 py-2">Name</th>
							<th class="text-left px-4 py-2">Phone</th>
							<th class="text-left px-4 py-2">Address</th>
							<th class="text-left px-4 py-2">Joined</th>
							<th class="px-4 py-2 text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="row in props.clienteles.data" :key="row.ClientCode" class="border-t">
							<td class="px-4 py-2">{{ row.ClientCode }}</td>
							<td class="px-4 py-2">{{ row.LastName }}, {{ row.FirstName }}</td>
							<td class="px-4 py-2">{{ row.TelNum }}</td>
							<td class="px-4 py-2">{{ row.Addr1 }}</td>
							<td class="px-4 py-2">{{ row.DateOfMembership ? row.DateOfMembership.slice(0,10) : '' }}</td>
							<td class="px-4 py-2 text-right">
								<SecondaryButton class="me-2" @click="openEdit(row)">Edit</SecondaryButton>
								<DangerButton @click="openDelete(row)">Delete</DangerButton>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- Pagination -->
				<div class="p-3 flex justify-between items-center text-sm text-gray-600">
					<div>Showing {{ props.clienteles.from }} - {{ props.clienteles.to }} of {{ props.clienteles.total }}</div>
					<div class="flex gap-1">
						<a v-for="link in props.clienteles.links" :key="link.label" :href="link.url || '#'" class="px-2 py-1 rounded" :class="link.active ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'" v-html="link.label" />
					</div>
				</div>
			</div>
		</div>

		<!-- Client Modal (rich UI reused from Admin) -->
		<ClientModal :show="showClientModal" :client="selectedClient" :isEditing="isEditingClient" @close="showClientModal = false" @submit="handleClientSubmit" />

		<!-- Delete Modal -->
		<DialogModal :show="showDelete" @close="showDelete = false">
			<template #title>Delete Client</template>
			<template #content>
				<p>Are you sure you want to delete <strong>{{ selected?.LastName }}, {{ selected?.FirstName }}</strong> ({{ selected?.ClientCode }})?</p>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showDelete = false">Cancel</SecondaryButton>
				<DangerButton @click="submitDelete">Delete</DangerButton>
			</template>
		</DialogModal>
	</AppLayout>
</template>
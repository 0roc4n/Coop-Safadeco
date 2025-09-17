<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ClerkSidebar from '@/Components/ClerkSidebar.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DialogModal from '@/Components/DialogModal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const showAddMember = ref(false)
const showUpdateProfile = ref(false)
const showImport = ref(false)

const memberForm = ref({ code: '', name: '', email: '', mobile: '' })
const profileForm = ref({ code: '', address: '', employer: '', position: '' })
const importForm = ref({ file: null, type: 'profiles' })
const errors = ref({})

function validate(form) {
	const e = {}
	Object.entries(form).forEach(([k, v]) => { if (v === '' || v === null) e[k] = 'Required' })
	return e
}

function submit(which) {
	let form
	if (which === 'member') form = memberForm.value
	if (which === 'profile') form = profileForm.value
	if (which === 'import') form = { type: importForm.value.type, file: importForm.value.file }
	const e = validate(form)
	errors.value = e
	if (Object.keys(e).length) return
	closeAll()
}

function closeAll() {
	showAddMember.value = false
	showUpdateProfile.value = false
	showImport.value = false
}

// Widgets sample data
const pendingProfiles = ref(18)
const recentMembers = ref([
	{ code: 'M-23001', name: 'Juan Dela Cruz' },
	{ code: 'M-23002', name: 'Maria Santos' },
])
const importStatus = ref({ success: 120, failed: 3 })

function downloadReport(which) {
	// TODO: Link to backend report endpoints
}
</script>

<template>
    <AppLayout title="Clerk Dashboard">
		<Head title="Clerk Dashboard" />

        <template #sidebar>
            <ClerkSidebar :current="'dashboard'" />
        </template>

		<div class="w-full">
			<!-- Top Bar / Quick Actions -->
			<div class="flex flex-wrap items-center justify-between mb-6 gap-3">
				<div>
					<h1 class="text-2xl font-bold text-gray-800">Clerk Dashboard</h1>
					<p class="text-sm text-gray-500">Fast, simple, and focused on data encoding</p>
				</div>
				<div class="flex flex-wrap gap-2">
					<PrimaryButton @click="showAddMember = true">Add New Member</PrimaryButton>
					<SecondaryButton @click="showUpdateProfile = true">Update Profile</SecondaryButton>
					<PrimaryButton @click="showImport = true">Import Data</PrimaryButton>
				</div>
			</div>

			<!-- Widgets Row -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Pending Profiles to Encode</div>
					<div class="text-2xl font-bold text-blue-700">{{ pendingProfiles }}</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Recently Added Members</div>
					<ul class="mt-1 space-y-1 text-sm">
						<li v-for="m in recentMembers" :key="m.code" class="flex justify-between">
							<span class="text-gray-700">{{ m.name }}</span>
							<span class="text-gray-400">{{ m.code }}</span>
						</li>
					</ul>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500">Data Import Status</div>
					<div class="text-sm mt-1"><span class="text-green-700 font-semibold">Success:</span> {{ importStatus.success }}</div>
					<div class="text-sm"><span class="text-red-600 font-semibold">Failed:</span> {{ importStatus.failed }}</div>
				</div>
			</div>

			<!-- Main Panels -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Member Management</h2>
						<div class="flex gap-2">
							<PrimaryButton @click="showAddMember = true">Add Member</PrimaryButton>
							<SecondaryButton @click="showUpdateProfile = true">Edit Profile</SecondaryButton>
						</div>
					</div>
					<div class="text-sm text-gray-500">Add/edit members, manage contact and employment information.</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Record Maintenance</h2>
						<SecondaryButton>Update Records</SecondaryButton>
					</div>
					<div class="text-sm text-gray-500">Update savings, share capital, and loan records.</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100 lg:col-span-2">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-lg font-semibold">Utilities</h2>
						<PrimaryButton @click="showImport = true">Import</PrimaryButton>
					</div>
					<div class="text-sm text-gray-500">Import departments, offices, profiles, and initial balances.</div>
				</div>
				<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
					<div class="text-sm text-gray-500 mb-2">Reports</div>
					<div class="space-y-2">
						<SecondaryButton class="w-full" @click="downloadReport('masterlist')">Masterlist of Members</SecondaryButton>
						<SecondaryButton class="w-full" @click="downloadReport('lists')">Employees / Funders / Creditors</SecondaryButton>
					</div>
				</div>
			</div>
		</div>

		<!-- Modals -->
		<DialogModal :show="showAddMember" @close="showAddMember = false">
			<template #title>Add New Member</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div>
						<InputLabel value="Member Code" />
						<TextInput v-model="memberForm.code" class="w-full" />
						<InputError :message="errors.code" />
					</div>
					<div>
						<InputLabel value="Full Name" />
						<TextInput v-model="memberForm.name" class="w-full" />
						<InputError :message="errors.name" />
					</div>
					<div>
						<InputLabel value="Email" />
						<TextInput v-model="memberForm.email" type="email" class="w-full" />
						<InputError :message="errors.email" />
					</div>
					<div>
						<InputLabel value="Mobile" />
						<TextInput v-model="memberForm.mobile" class="w-full" />
						<InputError :message="errors.mobile" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showAddMember = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('member')">Save Member</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showUpdateProfile" @close="showUpdateProfile = false">
			<template #title>Update Profile</template>
			<template #content>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
					<div>
						<InputLabel value="Member Code" />
						<TextInput v-model="profileForm.code" class="w-full" />
						<InputError :message="errors.code" />
					</div>
					<div>
						<InputLabel value="Address" />
						<TextInput v-model="profileForm.address" class="w-full" />
					</div>
					<div>
						<InputLabel value="Employer" />
						<TextInput v-model="profileForm.employer" class="w-full" />
					</div>
					<div>
						<InputLabel value="Position" />
						<TextInput v-model="profileForm.position" class="w-full" />
					</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showUpdateProfile = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('profile')">Save Changes</PrimaryButton>
			</template>
		</DialogModal>

		<DialogModal :show="showImport" @close="showImport = false">
			<template #title>Import Data</template>
			<template #content>
				<div class="space-y-3">
					<div>
						<InputLabel value="Import Type" />
						<select v-model="importForm.type" class="mt-1 block w-full rounded-md border-gray-300">
							<option value="profiles">Profiles</option>
							<option value="departments">Departments</option>
							<option value="offices">Offices</option>
							<option value="initial-balances">Initial Balances</option>
						</select>
					</div>
					<div>
						<InputLabel value="CSV File" />
						<input type="file" @change="e => importForm.file = e.target.files[0]" accept=".csv" class="mt-1 block w-full" />
						<InputError :message="errors.file" />
					</div>
					<div class="text-sm text-gray-500">CSV format only. Validate data before importing to prevent errors.</div>
				</div>
			</template>
			<template #footer>
				<SecondaryButton class="me-2" @click="showImport = false">Cancel</SecondaryButton>
				<PrimaryButton @click="submit('import')">Import</PrimaryButton>
			</template>
		</DialogModal>
	</AppLayout>
</template>



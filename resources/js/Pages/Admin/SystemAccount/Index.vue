<template>
    <AppLayout title="System Accounts">
            <div class="py-10">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">System Accounts</h1>
                        <button @click="showCreateModal = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Create Account
                        </button>
                    </div>
                    <div class="mb-4 flex items-center gap-2">
                        <div class="relative w-full max-w-xs">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" /></svg>
                            </span>
                            <input v-model="search" type="text" placeholder="Search accounts..." class="pl-10 border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-200 bg-gray-50" />
                        </div>
                    </div>
                    <div>
                        <div class="flex border-b mb-4 overflow-x-auto">
                            <button
                                v-for="role in roles"
                                :key="role"
                                @click="activeRole = role"
                                :class="['px-4 py-2 -mb-px border-b-2 whitespace-nowrap', activeRole === role ? 'border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-100']"
                            >
                                {{ role }}
                            </button>
                        </div>
                        <div>
                            <ul>
                                <li
                                    v-for="account in filteredAccounts"
                                    :key="account.id"
                                    class="flex items-center justify-between py-3 border-b last:border-b-0 hover:bg-gray-50 px-2 rounded transition"
                                >
                                    <div class="flex items-center gap-3">
                                        <img :src="account.profile_photo_url" alt="avatar" class="w-9 h-9 rounded-full border" />
                                        <span class="font-medium text-gray-800">{{ account.name }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="text-blue-600 hover:underline text-sm" @click="editAccount(account)">Edit</button>
                                        <button class="text-red-500 hover:underline text-sm" @click="deleteAccount(account)">Delete</button>
                                    </div>
                                </li>
                                <li v-if="filteredAccounts.length === 0" class="text-gray-400 text-center py-8">No accounts found.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Toast Notification Component Usage -->
                <Toast v-if="toastMessage" :message="toastMessage" type="error" @close="toastMessage = ''" />
                <Toast v-if="successToastMessage" :message="successToastMessage" type="success" @close="successToastMessage = ''" />

                <!-- Create Account Modal -->
                <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl w-full max-w-md p-8 relative animate-fade-in border border-gray-200">
                        <button @click="showCreateModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 tracking-tight">Create Account</h2>
                        <form @submit.prevent="submitCreate" class="space-y-4" enctype="multipart/form-data">
                            <div class="flex flex-col items-center gap-2">
                                <label class="block text-sm font-medium mb-1 text-gray-700 w-full text-left">Profile Photo</label>
                                <div class="relative w-24 h-24 mb-2">
                                    <img v-if="profilePhotoPreview" :src="profilePhotoPreview" class="w-24 h-24 object-cover rounded-full border border-gray-300 shadow" />
                                    <div v-else class="w-24 h-24 flex items-center justify-center bg-gray-100 rounded-full border border-gray-300 text-gray-400">
                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-10 w-10' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4v16m8-8H4' /></svg>
                                    </div>
                                    <input type="file" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" @change="onProfilePhotoChange" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700">Name</label>
                                <input v-model="createForm.name" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-white/80 placeholder-gray-400" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700">Email</label>
                                <input v-model="createForm.email" type="email" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-white/80 placeholder-gray-400" required />
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium mb-1 text-gray-700">Password</label>
                                    <input v-model="createForm.password" type="password" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-white/80 placeholder-gray-400" required />
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium mb-1 text-gray-700">Confirm</label>
                                    <input v-model="createForm.password_confirmation" type="password" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-white/80 placeholder-gray-400" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-gray-700">Role</label>
                                <select v-model="createForm.role_id" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-white/80" required>
                                    <option value="" disabled>Select role</option>
                                    <option v-for="role in rolesWithId" :key="role.id" :value="role.id">{{ role.name }}</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="showCreateModal = false" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 bg-white/70 hover:bg-gray-100 transition">Cancel</button>
                                <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import Toast from '@/Components/Toast.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    systemAccounts: {
        type: Array,
        required: true
    }
});

const search = ref('');
const showCreateModal = ref(false);
const toastMessage = ref('');
const successToastMessage = ref('');
const createForm = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: '',
    profile_photo_path: null
});
const profilePhotoPreview = ref(null);

function onProfilePhotoChange(e) {
    const file = e.target.files[0];
    if (file) {
        createForm.value.profile_photo_path = file;
        const reader = new FileReader();
        reader.onload = (ev) => {
            profilePhotoPreview.value = ev.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        createForm.value.profile_photo_path = null;
        profilePhotoPreview.value = null;
    }
}

const rolesWithId = computed(() => {
    // Get unique roles with id and name
    const map = new Map();
    props.systemAccounts.forEach(acc => {
        if (acc.role && !map.has(acc.role.id)) {
            map.set(acc.role.id, { id: acc.role.id, name: acc.role.name });
        }
    });
    return Array.from(map.values());
});

const roles = computed(() => rolesWithId.value.map(r => r.name));
const activeRole = ref(roles.value[0] || '');

const filteredAccounts = computed(() => {
    return props.systemAccounts
        .filter(acc => acc.role?.name !== 'member')
        .filter(acc => acc.role?.name === activeRole.value)
        .filter(acc => acc.name.toLowerCase().includes(search.value.toLowerCase()));
});

function editAccount(account) {
    // TODO: Implement edit logic/modal
    alert('Edit: ' + account.name);
}
function deleteAccount(account) {
    // TODO: Implement delete logic/confirmation
    if (confirm('Delete ' + account.name + '?')) {
        // Call backend or emit event
    }
}
function submitCreate() {
    const formData = new FormData();
    
    // Add regular form fields
    formData.append('name', createForm.value.name);
    formData.append('email', createForm.value.email);
    formData.append('password', createForm.value.password);
    formData.append('password_confirmation', createForm.value.password_confirmation);
    formData.append('role_id', createForm.value.role_id);
    
    // Add profile photo if it exists
    if (createForm.value.profile_photo_path instanceof File) {
        formData.append('profile_photo_path', createForm.value.profile_photo_path);
    }
    
    router.post('/admin/system-accounts/create', formData, {
        forceFormData: true,
        onSuccess: () => {
            successToastMessage.value = 'Account created successfully!';
            setTimeout(() => { successToastMessage.value = ''; }, 5000);
            showCreateModal.value = false;
            createForm.value = { name: '', email: '', password: '', password_confirmation: '', role_id: '', profile_photo_path: null };
            profilePhotoPreview.value = null;
        },
        onError: (errors) => {
            let msg = '';
            if (typeof errors === 'string') {
                msg = errors;
            } else if (typeof errors === 'object' && errors !== null) {
                msg = Object.values(errors).flat().join(' ');
            } else {
                msg = 'An error occurred.';
            }
            toastMessage.value = msg;
            setTimeout(() => { toastMessage.value = ''; }, 5000);
        }
    });
}
</script>
<style scoped>
/* Toast fade animation */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.2s ease;
}

</style>

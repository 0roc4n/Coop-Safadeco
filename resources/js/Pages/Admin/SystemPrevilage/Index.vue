<template>
    <AppLayout title="System Privileges">
        <div class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                    <div class="p-4 sm:p-6">
                        <div class="flex justify-between items-center mb-4 sm:mb-6">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Role Privileges Management</h2>
                            
                            <!-- Create Role Button -->
                            <button 
                                @click="showCreateRoleModal = true"
                                class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-md hover:bg-blue-700 transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Role
                            </button>
                        </div>
                        
                        <!-- Toast Notification -->
                        <Toast v-if="toastMessage" :message="toastMessage" :type="toastType" @close="toastMessage = ''" />
                        
                        <div class="space-y-6">
                            <!-- Role Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                                <div v-for="role in roles" :key="role.id" class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-md hover:shadow-lg transition duration-200">
                                    <div class="border-b border-gray-100 bg-gray-50 p-2.5 sm:p-3.5 flex flex-wrap sm:flex-nowrap items-center justify-between">
                                        <h3 class="text-sm sm:text-base font-medium text-gray-800 mr-2">{{ role.name }}</h3>
                                        <div class="flex items-center gap-2 mt-1 sm:mt-0">
                                            <span class="text-xs text-gray-500 text-[10px] sm:text-xs">ID: {{ role.id }}</span>
                                            <span class="bg-blue-100 text-blue-700 text-[10px] sm:text-xs px-1.5 py-0.5 rounded-full">Role</span>
                                        </div>
                                    </div>
                                    
                                    <div class="p-3 sm:p-5">
                                        <!-- Privilege Controls -->
                                        <div class="space-y-4">
                                            <div v-if="role.privileges && role.privileges.length > 0" class="flex flex-col">
                                                <!-- Permissions UI -->
                                                <div class="grid grid-cols-2 sm:grid-cols-5 text-[10px] sm:text-xs font-medium text-gray-600 mb-2">
                                                    <div class="col-span-2 sm:col-span-1 mb-2 sm:mb-0">Permission</div>
                                                    <div class="col-span-2 sm:col-span-4 grid grid-cols-4 text-center">
                                                        <div>Read</div>
                                                        <div>Add</div>
                                                        <div>Update</div>
                                                        <div>Delete</div>
                                                    </div>
                                                </div>
                                                
                                                <!-- On Mobile: Stacked Layout -->
                                                <div class="block sm:hidden space-y-3 border-t border-gray-100 pt-3">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-medium text-xs">Read</span>
                                                        <PrivilegeToggle
                                                            :checked="!!role.privileges[0].can_read"
                                                            @update:checked="updatePrivilege(role.id, 'can_read', $event)"
                                                            :disabled="role.name === 'Admin'"
                                                        />
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-medium text-xs">Add</span>
                                                        <PrivilegeToggle
                                                            :checked="!!role.privileges[0].can_add"
                                                            @update:checked="updatePrivilege(role.id, 'can_add', $event)"
                                                            :disabled="role.name === 'Admin'"
                                                        />
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-medium text-xs">Update</span>
                                                        <PrivilegeToggle
                                                            :checked="!!role.privileges[0].can_update"
                                                            @update:checked="updatePrivilege(role.id, 'can_update', $event)"
                                                            :disabled="role.name === 'Admin'"
                                                        />
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-medium text-xs">Delete</span>
                                                        <PrivilegeToggle
                                                            :checked="!!role.privileges[0].can_delete"
                                                            @update:checked="updatePrivilege(role.id, 'can_delete', $event)"
                                                            :disabled="role.name === 'Admin'"
                                                        />
                                                    </div>
                                                </div>

                                                <!-- On Desktop: Grid Layout -->
                                                <div class="hidden sm:grid grid-cols-5 py-3 border-t border-gray-100 items-center">
                                                    <div class="col-span-1 font-medium text-xs">Access Control</div>
                                                    <div class="col-span-4 grid grid-cols-4">
                                                        <div class="flex justify-center">
                                                            <PrivilegeToggle
                                                                :checked="!!role.privileges[0].can_read"
                                                                @update:checked="updatePrivilege(role.id, 'can_read', $event)"
                                                                :disabled="role.name === 'Admin'"
                                                            />
                                                        </div>
                                                        <div class="flex justify-center">
                                                            <PrivilegeToggle
                                                                :checked="!!role.privileges[0].can_add"
                                                                @update:checked="updatePrivilege(role.id, 'can_add', $event)"
                                                                :disabled="role.name === 'Admin'"
                                                            />
                                                        </div>
                                                        <div class="flex justify-center">
                                                            <PrivilegeToggle
                                                                :checked="!!role.privileges[0].can_update"
                                                                @update:checked="updatePrivilege(role.id, 'can_update', $event)"
                                                                :disabled="role.name === 'Admin'"
                                                            />
                                                        </div>
                                                        <div class="flex justify-center">
                                                            <PrivilegeToggle
                                                                :checked="!!role.privileges[0].can_delete"
                                                                @update:checked="updatePrivilege(role.id, 'can_delete', $event)"
                                                                :disabled="role.name === 'Admin'"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="text-center py-4 text-gray-500">
                                                No privileges configured
                                            </div>

                                            <!-- Role Details -->
                                            <div class="mt-2 text-xs text-gray-500">
                                                <p>Created: {{ new Date(role.created_at).toLocaleString() }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Footer with Save Button -->
                                    <div class="bg-gray-50 border-t border-gray-100 p-3 sm:p-4 flex justify-end">
                                        <button 
                                            @click="savePrivileges(role.id)" 
                                            class="px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium transition"
                                            :disabled="role.name === 'Admin'"
                                        >
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Info Section -->
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 sm:p-4 mt-6 text-xs sm:text-sm text-blue-700">
                                <div class="flex flex-col sm:flex-row items-start">
                                    <div class="mb-2 sm:mb-0 sm:mr-3 text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium mb-1">About Privileges</p>
                                        <p>Privileges determine what actions users with specific roles can perform:</p>
                                        <ul class="ml-4 mt-1 list-disc">
                                            <li>Read: Allows viewing information</li>
                                            <li>Add: Allows creating new records</li>
                                            <li>Update: Allows modifying existing records</li>
                                            <li>Delete: Allows removing records</li>
                                        </ul>
                                        <p class="mt-2">Note: Admin privileges cannot be modified for security reasons.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Role Modal -->
        <div v-if="showCreateRoleModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl w-full max-w-md mx-4 p-5 sm:p-6 animate-fade-in">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Create New Role</h3>
                    <button @click="showCreateRoleModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="createRole">
                    <div class="mb-4">
                        <label for="roleName" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                        <input 
                            id="roleName" 
                            v-model="newRole.name" 
                            type="text" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter role name"
                        >
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Default Privileges</label>
                        
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="flex items-center">
                                <input 
                                    id="can_read" 
                                    v-model="newRole.can_read" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-blue-600 rounded"
                                >
                                <label for="can_read" class="ml-2">Can Read</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input 
                                    id="can_add" 
                                    v-model="newRole.can_add" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-blue-600 rounded"
                                >
                                <label for="can_add" class="ml-2">Can Add</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input 
                                    id="can_update" 
                                    v-model="newRole.can_update" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-blue-600 rounded"
                                >
                                <label for="can_update" class="ml-2">Can Update</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input 
                                    id="can_delete" 
                                    v-model="newRole.can_delete" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-blue-600 rounded"
                                >
                                <label for="can_delete" class="ml-2">Can Delete</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button 
                            type="button" 
                            @click="showCreateRoleModal = false" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                            :disabled="isSubmitting"
                        >
                            <span v-if="isSubmitting">Creating...</span>
                            <span v-else>Create Role</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import PrivilegeToggle from './Components/PrivilegeToggle.vue';

// Define props to receive data from controller
const props = defineProps({
    roles: {
        type: Array,
        required: true
    }
});

// Local state for UI management
const toastMessage = ref('');
const toastType = ref('success');
const pendingChanges = ref({});
const showCreateRoleModal = ref(false);
const isSubmitting = ref(false);
const newRole = ref({
    name: '',
    can_read: true,
    can_add: false,
    can_update: false,
    can_delete: false
});

// Deep clone of roles data for tracking changes
const originalRoles = JSON.parse(JSON.stringify(props.roles));
const roles = ref(props.roles);

// Function to update a privilege toggle
function updatePrivilege(roleId, privilege, value) {
    // Find the role and update its privilege
    const role = roles.value.find(r => r.id === roleId);
    if (role && role.privileges && role.privileges.length > 0) {
        role.privileges[0][privilege] = value ? 1 : 0;
        
        // Track pending changes
        if (!pendingChanges.value[roleId]) {
            pendingChanges.value[roleId] = {};
        }
        pendingChanges.value[roleId][privilege] = value ? 1 : 0;
    }
}

// Function to save changes
function savePrivileges(roleId) {
    if (!pendingChanges.value[roleId]) return;
    
    // Prepare data for API
    const roleData = {
        role_id: roleId,
        ...pendingChanges.value[roleId]
    };
    
    // Send update to the server
    router.post('/admin/system-privileges/update', roleData, {
        onSuccess: () => {
            toastType.value = 'success';
            toastMessage.value = 'Privileges updated successfully';
            setTimeout(() => { toastMessage.value = ''; }, 3000);
            
            // Clear pending changes for this role
            delete pendingChanges.value[roleId];
        },
        onError: (errors) => {
            toastType.value = 'error';
            toastMessage.value = Object.values(errors).flat().join(' ');
            setTimeout(() => { toastMessage.value = ''; }, 3000);
        }
    });
}

// Function to create a new role
function createRole() {
    isSubmitting.value = true;
    
    // Prepare data for API
    const roleData = {
        name: newRole.value.name,
        can_read: newRole.value.can_read ? 1 : 0,
        can_add: newRole.value.can_add ? 1 : 0,
        can_update: newRole.value.can_update ? 1 : 0,
        can_delete: newRole.value.can_delete ? 1 : 0
    };
    
    // Send create request to the server
    router.post('/admin/system-privileges/create', roleData, {
        onSuccess: () => {
            toastType.value = 'success';
            toastMessage.value = 'Role created successfully';
            setTimeout(() => { toastMessage.value = ''; }, 3000);
            
            // Reset form and close modal
            resetNewRoleForm();
            showCreateRoleModal.value = false;
        },
        onError: (errors) => {
            toastType.value = 'error';
            toastMessage.value = Object.values(errors).flat().join(' ');
            setTimeout(() => { toastMessage.value = ''; }, 3000);
        },
        onFinish: () => {
            isSubmitting.value = false;
        }
    });
}

// Helper function to reset the new role form
function resetNewRoleForm() {
    newRole.value = {
        name: '',
        can_read: true,
        can_add: false,
        can_update: false,
        can_delete: false
    };
}
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
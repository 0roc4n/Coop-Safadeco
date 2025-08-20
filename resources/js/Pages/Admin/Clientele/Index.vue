<template>
    <AppLayout title="Client Management">
        <div class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Client Management</h1>
                                <p class="text-gray-600 mt-1">Manage SAFADECO cooperative members and clients</p>
                            </div>
                            
                            <!-- Create Client Button -->
                            <button 
                                @click="showCreateModal = true"
                                class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-lg hover:shadow-xl"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add New Client
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Toast Notification -->
                <Toast v-if="toastMessage" :message="toastMessage" :type="toastType" @close="toastMessage = ''" />

                <!-- Search and Filter Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input 
                                        v-model="searchQuery"
                                        type="text" 
                                        placeholder="Search clients by name or client code..."
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    >
                                </div>
                            </div>
                            <div class="sm:w-48">
                                <select 
                                    v-model="selectedClientType"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">All Client Types</option>
                                    <option value="1">Regular Member</option>
                                    <option value="2">Associate Member</option>
                                    <option value="3">Honorary Member</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Table Section -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-xl border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Client Directory</h3>
                            <span class="text-sm text-gray-500">
                                {{ filteredClients.length }} client{{ filteredClients.length !== 1 ? 's' : '' }} found
                            </span>
                        </div>
                    </div>

                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/80 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Client Info</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Membership</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Financial</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="client in paginatedClients" :key="client.ClientCode" class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <!-- Client Info -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                                    {{ getInitials(client.FirstName, client.LastName) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ client.LastName }}, {{ client.FirstName }}
                                                    <span v-if="client.MiddleName" class="text-gray-600">{{ client.MiddleName.charAt(0) }}.</span>
                                                </div>
                                                <div class="text-sm text-gray-500">{{ client.ClientCode }}</div>
                                                <div v-if="client.Occupation" class="text-xs text-gray-400">{{ client.Occupation }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div v-if="client.TelNum" class="flex items-center mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ client.TelNum }}
                                            </div>
                                            <div v-if="client.Addr1" class="flex items-start">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="text-xs">{{ client.Addr1 }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Membership -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="flex items-center mb-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="getClientTypeColor(client.ClientType)">
                                                    {{ getClientTypeName(client.ClientType) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Member since {{ formatDate(client.DateOfMembership) }}
                                            </div>
                                            <div v-if="client.DtBirth" class="text-xs text-gray-400 mt-1">
                                                {{ getAge(client.DtBirth) }} years old
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Financial -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div v-if="client.MonthlySalary" class="text-gray-900 font-medium">
                                                ₱{{ formatCurrency(client.MonthlySalary) }}
                                            </div>
                                            <div class="text-xs text-gray-500">Monthly Salary</div>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button 
                                                @click="editClient(client)"
                                                class="inline-flex items-center p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors duration-150"
                                                title="Edit Client"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button 
                                                @click="deleteClient(client)"
                                                class="inline-flex items-center p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                                title="Delete Client"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Empty State -->
                        <div v-if="filteredClients.length === 0" class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No clients found</h3>
                            <p class="text-gray-500">Try adjusting your search criteria or add a new client.</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="filteredClients.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ (currentPage - 1) * itemsPerPage + 1 }} to {{ Math.min(currentPage * itemsPerPage, filteredClients.length) }} of {{ filteredClients.length }} results
                            </div>
                            <div class="flex items-center space-x-2">
                                <button 
                                    @click="currentPage = Math.max(1, currentPage - 1)"
                                    :disabled="currentPage === 1"
                                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Previous
                                </button>
                                <span class="px-3 py-2 text-sm font-medium text-gray-700">
                                    Page {{ currentPage }} of {{ totalPages }}
                                </span>
                                <button 
                                    @click="currentPage = Math.min(totalPages, currentPage + 1)"
                                    :disabled="currentPage === totalPages"
                                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <ClientModal 
            v-if="showCreateModal || showEditModal"
            :show="showCreateModal || showEditModal"
            :client="editingClient"
            :isEditing="showEditModal"
            @close="closeModal"
            @submit="handleSubmit"
        />

        <!-- Delete Confirmation Modal -->
        <DeleteConfirmModal 
            v-if="showDeleteModal"
            :show="showDeleteModal"
            :client="deletingClient"
            @close="showDeleteModal = false"
            @confirm="confirmDelete"
        />
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import ClientModal from './Components/ClientModal.vue';
import DeleteConfirmModal from './Components/DeleteConfirmModal.vue';

// Props
const props = defineProps({
    clienteles: {
        type: Object,
        required: true
    }
});

// Reactive state
const searchQuery = ref('');
const selectedClientType = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(10);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const editingClient = ref(null);
const deletingClient = ref(null);
const toastMessage = ref('');
const toastType = ref('success');

// Computed properties
const filteredClients = computed(() => {
    let clients = props.clienteles.data || [];
    
    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        clients = clients.filter(client => 
            client.FirstName?.toLowerCase().includes(query) ||
            client.LastName?.toLowerCase().includes(query) ||
            client.ClientCode?.toLowerCase().includes(query)
        );
    }
    
    // Filter by client type
    if (selectedClientType.value) {
        clients = clients.filter(client => client.ClientType == selectedClientType.value);
    }
    
    return clients;
});

const totalPages = computed(() => {
    return Math.ceil(filteredClients.value.length / itemsPerPage.value);
});

const paginatedClients = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredClients.value.slice(start, end);
});

// Watch for search/filter changes to reset pagination
watch([searchQuery, selectedClientType], () => {
    currentPage.value = 1;
});

// Methods
const getInitials = (firstName, lastName) => {
    return (firstName?.charAt(0) || '') + (lastName?.charAt(0) || '');
};

const getClientTypeName = (type) => {
    const types = {
        1: 'Regular Member',
        2: 'Associate Member',
        3: 'Honorary Member'
    };
    return types[type] || 'Unknown';
};

const getClientTypeColor = (type) => {
    const colors = {
        1: 'bg-green-100 text-green-800',
        2: 'bg-blue-100 text-blue-800',
        3: 'bg-purple-100 text-purple-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
};

const formatCurrency = (amount) => {
    if (!amount) return '0.00';
    return new Intl.NumberFormat('en-PH', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
};

const getAge = (birthDate) => {
    if (!birthDate) return '';
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    return age;
};

const editClient = (client) => {
    editingClient.value = { ...client };
    showEditModal.value = true;
};

const deleteClient = (client) => {
    deletingClient.value = client;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
    editingClient.value = null;
};

const handleSubmit = (clientData) => {
    if (showEditModal.value) {
        router.post(`/admin/clientele/${editingClient.value.ClientCode}`, {
            ...clientData,
            _method: 'PUT'
        }, {
            onSuccess: () => {
                toastType.value = 'success';
                toastMessage.value = 'Client updated successfully';
                closeModal();
                setTimeout(() => { toastMessage.value = ''; }, 3000);
            },
            onError: (errors) => {
                const errorMessage = Object.values(errors).join(', ');
                toastType.value = 'error';
                toastMessage.value = 'Failed to update client: ' + errorMessage;
                setTimeout(() => { toastMessage.value = ''; }, 3000);
            }
        });
    } else {
        router.post('/admin/clientele', clientData, {
            onSuccess: () => {
                toastType.value = 'success';
                toastMessage.value = 'Client created successfully';
                closeModal();
                setTimeout(() => { toastMessage.value = ''; }, 3000);
            },
            onError: (errors) => {
                const errorMessage = Object.values(errors).join(', ');
                console.log(errorMessage);
                toastType.value = 'error';
                toastMessage.value = 'Failed to update client: ' + errorMessage;
                setTimeout(() => { toastMessage.value = ''; }, 5000);
            }
        });
    }
};

const confirmDelete = () => {
    router.delete(`/admin/clientele/${deletingClient.value.ClientCode}`, {
        onSuccess: () => {
            toastType.value = 'success';
            toastMessage.value = 'Client deleted successfully';
            showDeleteModal.value = false;
            deletingClient.value = null;
            setTimeout(() => { toastMessage.value = ''; }, 3000);
        },
        onError: (errors) => {
            toastType.value = 'error';
            toastMessage.value = 'Failed to delete client';
            setTimeout(() => { toastMessage.value = ''; }, 3000);
        }
    });
};

// Show success/error messages from server
onMounted(() => {
    if (props.clienteles.message) {
        toastType.value = 'success';
        toastMessage.value = props.clienteles.message;
        setTimeout(() => { toastMessage.value = ''; }, 3000);
    }
});
</script>

<style scoped>
.transition-all {
    transition: all 0.3s ease;
}
</style>

<template>
    <Head title="Books & Journals" />
    <AppLayout>
         <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books & Journals Management
        </h2>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Action Bar -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <input v-model="search" 
                                   type="text" 
                                   placeholder="Search books..." 
                                   class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm px-3 py-2 mr-4">
                            
                            <div class="relative">
                                <select v-model="dateFilter" 
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm px-3 py-2 appearance-none pr-8">
                                    <option value="all">All Dates</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <button @click="openAddModal" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Book/Journal
                        </button>
                    </div>
                    
                    <!-- Flash Message -->
                    <div v-if="$page.props.flash && $page.props.flash.success" 
                         class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" 
                         role="alert">
                        <p>{{ $page.props.flash.success }}</p>
                    </div>
                    
                    <!-- Books Table -->
                    <div class="overflow-x-auto bg-white rounded shadow">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Date Created
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Period (From - To)
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="filteredBooks.length === 0">
                                    <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                        No books found
                                    </td>
                                </tr>
                                <tr v-for="book in filteredBooks" :key="book.FolderKey" class="hover:bg-gray-50">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ book.FolderKey }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ book.Description }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ formatDate(book.DateCreated) }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ formatDate(book.DateFrom) }} - {{ book.DateTo ? formatDate(book.DateTo) : 'Present' }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span :class="getStatusClass(book)">
                                            {{ getStatus(book) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center space-x-4">
                                            <button @click="editBook(book)" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button @click="confirmDelete(book)" class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add/Edit Modal -->
        <div v-if="showModal" class="fixed inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="submitForm">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        {{ editMode ? 'Edit Book/Journal' : 'Add New Book/Journal' }}
                                    </h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <input type="text" 
                                                   id="description" 
                                                   v-model="form.Description" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   maxlength="32"
                                                   required>
                                            <div v-if="errors.Description" class="text-red-500 text-sm mt-1">{{ errors.Description }}</div>
                                        </div>
                                        
                                        <div>
                                            <label for="dateFrom" class="block text-sm font-medium text-gray-700">Date From</label>
                                            <input type="date" 
                                                   id="dateFrom" 
                                                   v-model="form.DateFrom" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   required>
                                            <div v-if="errors.DateFrom" class="text-red-500 text-sm mt-1">{{ errors.DateFrom }}</div>
                                        </div>
                                        
                                        <div>
                                            <label for="dateTo" class="block text-sm font-medium text-gray-700">Date To</label>
                                            <input type="date" 
                                                   id="dateTo" 
                                                   v-model="form.DateTo" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <div v-if="errors.DateTo" class="text-red-500 text-sm mt-1">{{ errors.DateTo }}</div>
                                        </div>
                                        
                                        <div>
                                            <label for="closing" class="block text-sm font-medium text-gray-700">Closing Date</label>
                                            <input type="date" 
                                                   id="closing" 
                                                   v-model="form.Closing" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <div v-if="errors.Closing" class="text-red-500 text-sm mt-1">{{ errors.Closing }}</div>
                                        </div>
                                        
                                        <div>
                                            <label for="purging" class="block text-sm font-medium text-gray-700">Purging Date</label>
                                            <input type="date" 
                                                   id="purging" 
                                                   v-model="form.Purging" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <div v-if="errors.Purging" class="text-red-500 text-sm mt-1">{{ errors.Purging }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ editMode ? 'Update' : 'Save' }}
                            </button>
                            <button type="button"
                                    @click="showModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Delete Book/Journal
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this book/journal? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="deleteBook"
                                type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button @click="showDeleteModal = false"
                                type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch } from 'vue';

const props = defineProps({
    books: Array
});

// Get the page object for accessing flash messages
const page = usePage();

// State variables
const search = ref('');
const dateFilter = ref('all');
const showModal = ref(false);
const showDeleteModal = ref(false);
const editMode = ref(false);
const selectedBook = ref(null);
const errors = ref({});

// Form for adding/editing books
const form = useForm({
    Description: '',
    DateFrom: '',
    DateTo: '',
    Closing: '',
    Purging: ''
});

// Create a local flash message state
const flashMessage = ref('');

// Watch for flash messages from the page props
watch(() => page.props.flash, (newFlash) => {
    if (newFlash && newFlash.success) {
        flashMessage.value = newFlash.success;
        
        // Clear the flash message after 5 seconds
        setTimeout(() => {
            flashMessage.value = '';
        }, 5000);
    }
}, { deep: true, immediate: true });

// Filter books based on search and date filter
const filteredBooks = computed(() => {
    let filtered = props.books;
    
    if (search.value) {
        const searchLower = search.value.toLowerCase();
        filtered = filtered.filter(book => 
            book.Description.toLowerCase().includes(searchLower) || 
            book.FolderKey.toString().includes(searchLower)
        );
    }
    
    if (dateFilter.value !== 'all') {
        const today = new Date();
        const startOfWeek = new Date(today);
        startOfWeek.setDate(today.getDate() - today.getDay());
        
        const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        const startOfYear = new Date(today.getFullYear(), 0, 1);
        
        filtered = filtered.filter(book => {
            const bookDate = new Date(book.DateCreated);
            
            switch (dateFilter.value) {
                case 'today':
                    return bookDate.toDateString() === today.toDateString();
                case 'week':
                    return bookDate >= startOfWeek;
                case 'month':
                    return bookDate >= startOfMonth;
                case 'year':
                    return bookDate >= startOfYear;
                default:
                    return true;
            }
        });
    }
    
    return filtered;
});

// Format date for display
const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

// Get book status based on dates
const getStatus = (book) => {
    const now = new Date();
    const closing = book.Closing ? new Date(book.Closing) : null;
    const purging = book.Purging ? new Date(book.Purging) : null;
    
    if (purging && now >= purging) {
        return 'Purged';
    } else if (closing && now >= closing) {
        return 'Closed';
    } else {
        return 'Active';
    }
};

// Get CSS class for status badge
const getStatusClass = (book) => {
    const status = getStatus(book);
    
    switch (status) {
        case 'Active':
            return 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
        case 'Closed':
            return 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800';
        case 'Purged':
            return 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
        default:
            return 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800';
    }
};

// Open modal for adding a new book
const openAddModal = () => {
    editMode.value = false;
    form.reset();
    form.clearErrors();
    errors.value = {};
    showModal.value = true;
};

// Open modal for editing a book
const editBook = (book) => {
    editMode.value = true;
    selectedBook.value = book;
    
    form.reset();
    form.clearErrors();
    errors.value = {};
    
    // Format dates for input fields
    const formatForInput = (dateString) => {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toISOString().split('T')[0];
    };
    
    form.Description = book.Description || '';
    form.DateFrom = formatForInput(book.DateFrom);
    form.DateTo = formatForInput(book.DateTo);
    form.Closing = formatForInput(book.Closing);
    form.Purging = formatForInput(book.Purging);
    
    showModal.value = true;
};

// Submit form for adding or updating a book
const submitForm = () => {
    if (editMode.value) {
        form.put(`/admin/book-journals/${selectedBook.value.FolderKey}`, {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
            },
            onError: (err) => {
                errors.value = err;
            }
        });
    } else {
        form.post('/admin/book-journals', {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
            },
            onError: (err) => {
                errors.value = err;
            }
        });
    }
};

// Confirm delete book
const confirmDelete = (book) => {
    selectedBook.value = book;
    showDeleteModal.value = true;
};

// Delete book
const deleteBook = () => {
    form.delete(`/admin/book-journals/${selectedBook.value.FolderKey}`, {
        onSuccess: () => {
            showDeleteModal.value = false;
        },
        onError: (err) => {
            console.error('Error deleting book:', err);
        }
    });
};
</script>
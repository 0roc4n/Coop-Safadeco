<template>
  <div>
    <!-- Collapsed state: Only arrow button visible -->
    <div v-if="isCollapsed" class="fixed left-0 top-10 z-50 h-screen flex items-start pt-4">
      <button
        @click="toggleSidebar"
        class="bg-blue-800 text-white p-3 rounded-r-lg shadow-lg hover:bg-blue-700 transition-colors duration-200"
        aria-label="Expand sidebar"
      >
        <ChevronRight class="w-5 h-5" />
      </button>
    </div>

    <!-- Expanded state: Full sidebar with all navigation -->
    <aside
      v-else
      class="bg-blue-800 text-white min-h-screen flex flex-col transition-all duration-300 ease-in-out w-64"
    >
      <!-- Header with logo and collapse button -->
      <div class="px-4 py-3 flex items-end justify-end border-b border-blue-900">
        <button
          @click="toggleSidebar"
          class="text-white p-1 rounded hover:bg-blue-700 focus:outline-none transition-colors duration-200"
          aria-label="Collapse sidebar"
        >
          <ChevronRight class="w-5 h-5 rotate-180" />
        </button>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <SidebarLink :href="route('dashboard')" label="Dashboard" :icon="Home" />

        <SidebarDropdown
          label="Client & Account Management"
          :icon="Users"
          :items="[
            { href: route('admin.clientele.index'), label: 'Clientele Management' },
            { href: route('admin.account-codes.index'), label: 'Account Code' },
          ]"
        />

        <SidebarDropdown
          label="Loan & Product Management"
          :icon="DollarSign"
          :items="[
            { href: route('admin.loan-applications.index'), label: 'Loan Application' },
            { href: route('admin.loan-products.index'), label: 'Loan Products' },
            { href: '#', label: 'Loan Adjustments' },
          ]"
        />

        <SidebarDropdown
          label="Financials & Transactions"
          :icon="Calculator"
          :items="[
            { href: route('admin.book-journals.index'), label: 'Book/Journals' },
            { href: route('billing.statements.index'), label: 'Billing Statements' },
            { href: '#', label: 'Projections' },
            { href: '#', label: 'Past Due Settings' },
            { href: '#', label: 'Annual Fees' },
          ]"
        />

        <SidebarDropdown
          label="System Administration"
          :icon="Settings"
          :items="[
            { href: route('admin.system-account.index'), label: 'System Accounts' },
            { href: route('admin.system-previlage.index'), label: 'Accounts Privilege' },
          ]"
        />

        <SidebarLink :href="route('profile.show')" label="Profile" :icon="User" />
      </nav>
    </aside>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { ChevronRight, Home, Users, DollarSign, Calculator, Settings, User } from 'lucide-vue-next'
import SidebarDropdown from './SidebarDropdown.vue'
import SidebarLink from './SidebarLink.vue'

// Use the route function from Inertia or fallback to safe default
const route = (name, params = {}) => {
  try {
    return window.route(name, params)
  } catch (error) {
    console.warn(`Route "${name}" not found, using fallback`, error)
    return '#'
  }
}

const isCollapsed = ref(false)

// Toggle sidebar collapsed state
const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
  // Save collapsed state to localStorage
  localStorage.setItem('sidebarCollapsed', isCollapsed.value ? 'true' : 'false')
}

// Restore sidebar state on component mount
onMounted(() => {
  const savedState = localStorage.getItem('sidebarCollapsed')
  if (savedState) {
    isCollapsed.value = savedState === 'true'
  }
})
</script>

<template>
  <div>
    <!-- Mobile Hamburger Menu Button (visible on mobile only) -->
    <button
      v-show="isMobile"
      @click="toggleMobileSidebar"
      class="fixed top-4 left-4 z-50 bg-blue-800 text-white p-3 rounded-lg shadow-lg hover:bg-blue-700 transition-all duration-200 lg:hidden"
      aria-label="Toggle mobile menu"
    >
      <div class="w-6 h-6 flex flex-col justify-center items-center">
        <span :class="['bg-white block transition-all duration-300 ease-out h-0.5 w-6 rounded-sm', isMobileOpen ? 'rotate-45 translate-y-1' : '-translate-y-0.5']"></span>
        <span :class="['bg-white block transition-all duration-300 ease-out h-0.5 w-6 rounded-sm my-0.5', isMobileOpen ? 'opacity-0' : 'opacity-100']"></span>
        <span :class="['bg-white block transition-all duration-300 ease-out h-0.5 w-6 rounded-sm', isMobileOpen ? '-rotate-45 -translate-y-1' : 'translate-y-0.5']"></span>
      </div>
    </button>

    <!-- Mobile Overlay -->
    <div
      v-show="isMobile && isMobileOpen"
      @click="closeMobileSidebar"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden transition-opacity duration-300"
      aria-hidden="true"
    ></div>

    <!-- Desktop Collapsed State: Only arrow button visible -->
    <div 
      v-if="!isMobile && isCollapsed" 
      class="fixed left-0 top-10 z-50 h-screen flex items-start pt-4"
    >
      <button
        @click="toggleDesktopSidebar"
        class="bg-blue-800 text-white p-3 rounded-r-lg shadow-lg hover:bg-blue-700 transition-colors duration-200"
        aria-label="Expand sidebar"
      >
        <ChevronRight class="w-5 h-5" />
      </button>
    </div>

    <!-- Main Sidebar -->
    <aside
      :class="[
        'bg-blue-800 text-white min-h-screen flex flex-col transition-all duration-300 ease-in-out z-50',
        // Desktop styles
        'lg:relative lg:translate-x-0',
        !isMobile && !isCollapsed ? 'lg:w-64' : 'lg:w-0 lg:overflow-hidden',
        // Mobile styles
        'lg:block',
        isMobile ? [
          'fixed top-0 left-0 w-80 max-w-[85vw] transform',
          isMobileOpen ? 'translate-x-0' : '-translate-x-full'
        ] : []
      ]"
    >
      <!-- Header with logo and toggle button -->
      <div class="px-4 py-3 flex items-center justify-end border-b border-blue-900">
        <!-- Logo/Brand (visible on mobile and expanded desktop) -->
        <!-- <div class="flex items-center">
          <img src="/images/logo.png" alt="Logo" class="h-8 w-8 mr-2" />
          <h1 class="text-lg font-semibold text-white">SAFADECO</h1>
        </div> -->
        
        <!-- Desktop collapse button -->
        <button
          v-if="!isMobile"
          @click="toggleDesktopSidebar"
          class="text-white p-1 rounded hover:bg-blue-700 focus:outline-none transition-colors duration-200"
          aria-label="Collapse sidebar"
        >
          <ChevronRight class="w-5 h-5 rotate-180" />
        </button>

        <!-- Mobile close button -->
        <button
          v-if="isMobile"
          @click="closeMobileSidebar"
          class="text-white p-1 rounded hover:bg-blue-700 focus:outline-none transition-colors duration-200"
          aria-label="Close sidebar"
        >
          <X class="w-5 h-5" />
        </button>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <SidebarLink :href="route('dashboard')" label="Dashboard" :icon="Home" @click="handleLinkClick" />

        <SidebarDropdown
          label="Client & Account Management"
          :icon="Users"
          :items="[
            { href: route('admin.clientele.index'), label: 'Clientele Management' },
            { href: route('admin.account-codes.index'), label: 'Account Code' },
          ]"
          @link-click="handleLinkClick"
        />

        <SidebarDropdown
          label="Loan & Product Management"
          :icon="DollarSign"
          :items="[
            { href: route('admin.loan-applications.index'), label: 'Loan Application' },
            { href: route('admin.loan-products.index'), label: 'Loan Products' },
            { href: '#', label: 'Loan Adjustments' },
          ]"
          @link-click="handleLinkClick"
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
          @link-click="handleLinkClick"
        />

        <SidebarDropdown
          label="System Administration"
          :icon="Settings"
          :items="[
            { href: route('admin.system-account.index'), label: 'System Accounts' },
            { href: route('admin.system-previlage.index'), label: 'Accounts Privilege' },
          ]"
          @link-click="handleLinkClick"
        />

        <SidebarLink :href="route('profile.show')" label="Profile" :icon="User" @click="handleLinkClick" />
      </nav>
    </aside>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { ChevronRight, Home, Users, DollarSign, Calculator, Settings, User, X } from 'lucide-vue-next'
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

// Responsive state management
const windowWidth = ref(window.innerWidth)
const isCollapsed = ref(false)
const isMobileOpen = ref(false)

// Computed property to determine if we're on mobile
const isMobile = computed(() => windowWidth.value < 1024) // lg breakpoint

// Handle window resize
const handleResize = () => {
  windowWidth.value = window.innerWidth
  
  // Auto-close mobile sidebar when switching to desktop
  if (!isMobile.value && isMobileOpen.value) {
    isMobileOpen.value = false
  }
}

// Desktop sidebar toggle
const toggleDesktopSidebar = () => {
  isCollapsed.value = !isCollapsed.value
  // Save collapsed state to localStorage
  localStorage.setItem('sidebarCollapsed', isCollapsed.value ? 'true' : 'false')
}

// Mobile sidebar toggle
const toggleMobileSidebar = () => {
  isMobileOpen.value = !isMobileOpen.value
}

// Close mobile sidebar
const closeMobileSidebar = () => {
  isMobileOpen.value = false
}

// Handle link clicks (close mobile sidebar when navigating)
const handleLinkClick = () => {
  if (isMobile.value) {
    closeMobileSidebar()
  }
}

// Handle escape key to close mobile sidebar
const handleEscapeKey = (event) => {
  if (event.key === 'Escape' && isMobile.value && isMobileOpen.value) {
    closeMobileSidebar()
  }
}

// Lifecycle hooks
onMounted(() => {
  // Restore desktop sidebar state
  const savedState = localStorage.getItem('sidebarCollapsed')
  if (savedState) {
    isCollapsed.value = savedState === 'true'
  }
  
  // Add event listeners
  window.addEventListener('resize', handleResize)
  document.addEventListener('keydown', handleEscapeKey)
})

onUnmounted(() => {
  // Clean up event listeners
  window.removeEventListener('resize', handleResize)
  document.removeEventListener('keydown', handleEscapeKey)
})
</script>

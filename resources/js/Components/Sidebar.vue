<template>
  <aside class="w-64 bg-blue-800 text-white min-h-screen flex flex-col">
    <!-- <div class="px-4 py-5 flex items-center border-b border-blue-900">
      <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
        <span class="text-blue-800 font-bold text-lg">S</span>
      </div>
      <span class="ml-3 font-bold text-lg">SAFADECO</span>
    </div> -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
      <SidebarLink to="/user/dashboard" label="Dashboard" permission="can_read" />
      
      <SidebarDropdown 
        label="Client & Account Management" 
        permission="can_read"
        :items="[
          { to: '/clients', label: 'Clients', permission: 'can_read' },
          { to: '/account-code', label: 'Account Code', permission: 'can_read' }
        ]" 
      />
      
      <SidebarDropdown 
        label="Loan & Product Management" 
        permission="can_read"
        :items="[
          { to: '/loan-application', label: 'Loan Application', permission: 'can_read' },
          { to: '/loan-products', label: 'Loan Products', permission: 'can_read' },
          { to: '/loan-adjustments', label: 'Loan Adjustments', permission: 'can_update' }
        ]" 
      />
      
      <SidebarDropdown 
        label="Financials & Transactions" 
        permission="can_read"
        :items="[
          { to: '/book-journals', label: 'Book/Journals', permission: 'can_read' },
          { to: '/billing-statements', label: 'Billing Statements', permission: 'can_read' },
          { to: '/projections', label: 'Projections', permission: 'can_read' },
          { to: '/past-due-settings', label: 'Past Due Settings', permission: 'can_update' },
          { to: '/annual-fees', label: 'Annual Fees', permission: 'can_read' }
        ]" 
      />
      
      <SidebarDropdown 
        label="System Administration" 
        permission="can_read"
        requiredRole="Admin"
        :items="[
          { to: '/admin/systemaccounts', label: 'System Accounts', permission: 'can_read', requiredRole: 'Admin' },
          { to: '/admin/system-previlage', label: 'Accounts Privilege', permission: 'can_read', requiredRole: 'Admin' }
        ]" 
      />
      
      <SidebarLink to="/user/profile" label="Profile" permission="can_read" />
    </nav>
    <!-- <div class="px-4 py-4 border-t border-blue-900">
      <SidebarLink to="/logout" label="Logout" />
    </div> -->
  </aside>
</template>

<script setup>
import SidebarLink from './SidebarLink.vue';
import SidebarDropdown from './SidebarDropdown.vue';
</script>

<style scoped>
/* Make the sidebar slightly wider to accommodate dropdowns */
aside {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/* Hide scrollbar but maintain functionality */
nav {
  scrollbar-width: thin;
  scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
}

nav::-webkit-scrollbar {
  width: 4px;
}

nav::-webkit-scrollbar-track {
  background: transparent;
}

nav::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 20px;
}
</style>

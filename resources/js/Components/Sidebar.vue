<template>
  <aside class="w-56 bg-blue-800 text-white min-h-screen flex flex-col">
    <!-- <div class="px-4 py-5 flex items-center border-b border-blue-900">
      <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
        <span class="text-blue-800 font-bold text-lg">S</span>
      </div>
      <span class="ml-3 font-bold text-lg">SAFADECO</span>
    </div> -->
    <nav class="flex-1 px-4 py-6 space-y-3">
      <SidebarLink to="/user/dashboard" label="Dashboard" />
      <SidebarLink to="/clients" label="Clients" />
      <SidebarLink to="/accounts" label="Accounts" />
      <SidebarLink to="/loans" label="Loans" />
      <SidebarLink to="/savings" label="Savings" />
      <SidebarLink to="/admin/systemaccounts" label="System Accounts" />
      <SidebarLink to="/user/systemprevi" label="Accounts Previlige" />
      <SidebarLink to="/user/profile" label="Profile" />
    </nav>
    <!-- <div class="px-4 py-4 border-t border-blue-900">
      <SidebarLink to="/logout" label="Logout" />
    </div> -->
  </aside>
</template>

<script setup>
import SidebarLink from './SidebarLink.vue'
</script>

<style scoped>
/* Large clickable area, high contrast, readable font */
nav a {
  font-size: 1.1rem;
  padding: 0.75rem 1rem;
  border-radius: 0.375rem;
  display: block;
  color: #fff;
  background: none;
  transition: background 0.2s;
}
nav a:hover, nav a.active {
  background: #2563eb;
  color: #ffe066;
}
</style>

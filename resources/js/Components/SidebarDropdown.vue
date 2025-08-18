<template>
  <PermissionAwareLink :permission="permission" :requiredRole="requiredRole" v-slot="{ }" v-if="hasVisibleItems">
    <div class="sidebar-dropdown">
      <div 
        @click="isOpen = !isOpen" 
        class="dropdown-header" 
        :class="[hasActiveChild ? 'has-active-child' : '']"
      >
        <span>{{ label }}</span>
        <svg 
          xmlns="http://www.w3.org/2000/svg" 
          class="h-4 w-4 transition-transform" 
          :class="[isOpen ? 'rotate-180' : '']"
          fill="none" 
          viewBox="0 0 24 24" 
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
      <div 
        v-show="isOpen" 
        class="dropdown-content transition-all overflow-hidden"
      >
        <div v-for="item in items" :key="item.to" class="dropdown-item">
          <PermissionAwareLink 
            :permission="item.permission || 'can_read'" 
            :requiredRole="item.requiredRole" 
            v-slot="{ }">
            <a 
              :href="item.to" 
              class="sidebar-link-child"
              :class="[isActive(item.to) ? 'active' : '']"
            >
              {{ item.label }}
            </a>
          </PermissionAwareLink>
        </div>
      </div>
    </div>
  </PermissionAwareLink>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import PermissionAwareLink from './PermissionAwareLink.vue'

const props = defineProps({
  label: String,
  items: Array,
  defaultOpen: {
    type: Boolean,
    default: false
  },
  permission: {
    type: String,
    default: 'can_read'
  },
  requiredRole: {
    type: [String, Number],
    default: null
  }
})

const page = usePage()
const isOpen = ref(props.defaultOpen)
const userPermissions = computed(() => page.props.userPermissions)

const isActive = (path) => {
  return page.url === path || page.url.startsWith(path + '/')
}

// Check if item is visible based on permissions
const isItemVisible = (item) => {
  // Admin (role_id = 1) always has access to everything
  if (userPermissions.value?.role?.id === 1) {
    return true;
  }
  
  // If a specific role is required, check if user has that role
  if (item.requiredRole && 
      userPermissions.value?.role?.id !== item.requiredRole && 
      userPermissions.value?.role?.name !== item.requiredRole) {
    return false;
  }
  
  // Check the specific permission (default to can_read)
  const permission = item.permission || 'can_read';
  return userPermissions.value?.privileges?.[permission] === true;
}

// Filter visible items based on permissions
const visibleItems = computed(() => {
  return props.items.filter(isItemVisible);
})

// Check if there are any visible items
const hasVisibleItems = computed(() => {
  return visibleItems.value.length > 0;
})

const hasActiveChild = computed(() => {
  return props.items.some(item => isActive(item.to) && isItemVisible(item))
})

// If any child is active, open the dropdown by default
if (hasActiveChild.value && !props.defaultOpen) {
  isOpen.value = true
}
</script>

<style scoped>
.sidebar-dropdown {
  margin-bottom: 0.5rem;
}

.dropdown-header {
  font-size: 1.1rem;
  padding: 0.75rem 1rem;
  border-radius: 0.375rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #fff;
  background: none;
  cursor: pointer;
  transition: background 0.2s;
}

.dropdown-header:hover, .dropdown-header.has-active-child {
  background: rgba(255, 255, 255, 0.1);
}

.dropdown-header.has-active-child {
  color: #ffe066;
}

.dropdown-content {
  padding-left: 1rem;
  margin-top: 0.25rem;
}

.sidebar-link-child {
  font-size: 0.95rem;
  padding: 0.6rem 1rem;
  border-radius: 0.375rem;
  display: block;
  color: rgba(255, 255, 255, 0.85);
  background: none;
  transition: background 0.2s;
  text-decoration: none;
}

.sidebar-link-child:hover, .sidebar-link-child.active {
  background: #2563eb;
  color: #ffe066;
}
</style>

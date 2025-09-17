<template>
  <component :is="component" v-if="isVisible">
    <slot></slot>
  </component>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  permission: {
    type: String,
    required: false,
    validator: (value) => ['can_read', 'can_add', 'can_update', 'can_delete'].includes(value)
  },
  requiredRole: {
    type: [String, Number],
    required: false
  },
  component: {
    type: [String, Object],
    default: 'div'
  }
});

const page = usePage();
const userPermissions = computed(() => page.props.userPermissions);

// Check if the user has the required permission
const hasPermission = computed(() => {
  // Admin (role_id = 1) always has access to everything
  if (userPermissions.value?.role?.id === 1) {
    return true;
  }
  
  // If no specific permission is required, show the component
  if (!props.permission) {
    return true;
  }
  
  // If a specific role is required, check if user has that role
  if (props.requiredRole && userPermissions.value?.role?.id !== props.requiredRole &&
      userPermissions.value?.role?.name !== props.requiredRole) {
    return false;
  }
  
  // Check the specific permission
  return userPermissions.value?.privileges?.[props.permission] === true;
});

// Whether the component should be visible
const isVisible = computed(() => {
  return hasPermission.value;
});
</script>

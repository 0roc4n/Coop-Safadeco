<template>
  <a :href="to" :class="[isActive ? 'active' : '', 'sidebar-link']">
    <span>{{ label }}</span>
  </a>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  to: String,
  label: String
})

const page = usePage()
const isActive = computed(() => {
  return page.url === props.to
})
</script>

<style scoped>
.sidebar-link {
  font-size: 1.1rem;
  padding: 0.75rem 1rem;
  border-radius: 0.375rem;
  display: block;
  color: #fff;
  background: none;
  transition: background 0.2s;
  text-decoration: none;
}
.sidebar-link:hover, .sidebar-link.active {
  background: #2563eb;
  color: #ffe066;
}
</style>

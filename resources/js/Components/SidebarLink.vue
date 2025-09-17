<template>
  <Link
    :href="href"
    @click="$emit('click')"
    :class="[
      'flex items-center w-full px-4 py-3 text-white rounded-lg transition-all duration-200',
      'border-l-3 border-transparent hover:bg-blue-700 hover:text-yellow-300',
      isActive ? 'bg-blue-600 text-yellow-300 font-semibold border-l-yellow-300 shadow-lg shadow-yellow-300/20' : ''
    ]"
  >
    <div class="flex items-center justify-center mr-3 min-w-[1.5rem]">
      <component :is="icon" class="w-5 h-5" />
    </div>
    <span class="text-base">{{ label }}</span>
    <svg
      v-if="isActive"
      class="w-5 h-5 ml-auto"
      viewBox="0 0 20 20"
      fill="currentColor"
    >
      <path
        fill-rule="evenodd"
        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
        clip-rule="evenodd"
      />
    </svg>
  </Link>
</template>

<script setup>
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'

const props = defineProps({
  href: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  icon: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['click'])

const page = usePage()

const isActive = computed(() => {
  if (!props.href || props.href === '#') {
    return false
  }
  
  // Check if current URL matches the link URL or if it's a sub-path
  return page.url === props.href || (props.href !== '/' && page.url.startsWith(props.href + '/'))
})
</script>

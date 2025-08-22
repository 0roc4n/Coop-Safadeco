<template>
  <div class="mb-2">
    <!-- Dropdown Header -->
    <button
      @click="toggleDropdown"
      :class="[
        'flex items-center justify-between w-full px-4 py-3 text-white rounded-lg',
        'transition-all duration-200 border-l-3 border-transparent',
        'hover:bg-blue-700 hover:text-yellow-300',
        hasActiveChild ? 'bg-blue-600/50 text-yellow-300 font-semibold border-l-yellow-300' : ''
      ]"
    >
      <div class="flex items-center">
        <div class="flex items-center justify-center mr-3 min-w-[1.5rem]">
          <component :is="icon" class="w-5 h-5" />
        </div>
        <span class="text-base">{{ label }}</span>
      </div>
      <ChevronDown :class="['w-4 h-4 transition-transform duration-200', isOpen ? 'rotate-180' : '']" />
    </button>

    <!-- Dropdown Content -->
    <div
      :class="[
        'overflow-hidden transition-all duration-300 ease-in-out',
        isOpen ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
      ]"
    >
      <div class="pl-4 mt-1 space-y-1">
        <Link
          v-for="item in items"
          :key="item.href"
          :href="item.href"
          :class="[
            'flex items-center justify-between w-full px-4 py-2 text-sm rounded-lg',
            'transition-all duration-200 border-l-3 border-transparent',
            'hover:bg-blue-600 hover:text-yellow-300',
            isItemActive(item.href)
              ? 'bg-blue-600 text-yellow-300 font-medium border-l-yellow-300 shadow-md shadow-yellow-300/10'
              : 'text-white/85'
          ]"
        >
          <span>{{ item.label }}</span>
          <svg
            v-if="isItemActive(item.href)"
            class="w-4 h-4"
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
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { ChevronDown } from 'lucide-vue-next'
import { usePage, Link } from '@inertiajs/vue3'

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  icon: {
    type: Object,
    required: true
  },
  items: {
    type: Array,
    required: true
  },
  defaultOpen: {
    type: Boolean,
    default: false
  }
})

const isOpen = ref(props.defaultOpen)
const page = usePage()

const isItemActive = (href) => {
  if (!href || href === '#') {
    return false
  }
  
  return page.url === href || (href !== '/' && page.url.startsWith(href + '/'))
}

const hasActiveChild = computed(() => {
  return props.items.some(item => isItemActive(item.href))
})

// Auto-open if has active child
watch(hasActiveChild, (newValue) => {
  if (newValue && !isOpen.value) {
    isOpen.value = true
  }
})

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}
</script>

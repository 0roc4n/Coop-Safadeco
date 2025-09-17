<template>
  <transition name="fade">
    <div :class="[
      'fixed z-[100] animate-fade-in text-white rounded-lg shadow-lg flex items-center gap-2',
      'sm:top-6 sm:right-6 top-4 right-4 left-4 sm:left-auto',
      'px-3 sm:px-6 py-2 sm:py-3 text-sm',
      type === 'error' ? 'bg-red-600' : 'bg-green-600'
    ]">
      <svg v-if="type === 'error'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414-1.414A9 9 0 105.636 18.364l1.414 1.414A9 9 0 1018.364 5.636z" />
      </svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <span class="flex-grow">{{ message }}</span>
      <button @click="$emit('close')" class="ml-2 text-white/80 hover:text-white text-lg leading-none">&times;</button>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps({
  message: String,
  type: {
    type: String,
    default: 'success',
  },
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.2s ease;
}
</style>

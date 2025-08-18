<template>
    <div class="inline-flex items-center">
        <button 
            :class="[
                'sm:w-12 w-10 sm:h-6 h-5 flex items-center rounded-full p-1 duration-300 ease-in-out',
                checked ? 'bg-green-500 justify-end' : 'bg-gray-300 justify-start',
                disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
            ]"
            @click="toggleState"
            :disabled="disabled"
            type="button"
            aria-label="Toggle privilege"
        >
            <div class="bg-white sm:w-4 sm:h-4 w-3 h-3 rounded-full shadow-md transform duration-300 ease-in-out"></div>
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    checked: {
        type: Boolean,
        required: true
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:checked']);

function toggleState() {
    if (!props.disabled) {
        emit('update:checked', !props.checked);
    }
}
</script>

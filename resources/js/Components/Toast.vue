<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
    message: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'info', // success, error, warning, info
        validator: (value) => ['success', 'error', 'warning', 'info'].includes(value),
    },
    duration: {
        type: Number,
        default: 5000, // milliseconds
    },
});

const emit = defineEmits(['close']);

const isVisible = ref(true);

const iconClass = computed(() => {
    const icons = {
        success: 'text-emerald-600',
        error: 'text-red-600',
        warning: 'text-amber-600',
        info: 'text-blue-600',
    };
    return icons[props.type] || icons.info;
});

const bgClass = computed(() => {
    const bgs = {
        success: 'bg-emerald-50 border-emerald-200',
        error: 'bg-red-50 border-red-200',
        warning: 'bg-amber-50 border-amber-200',
        info: 'bg-blue-50 border-blue-200',
    };
    return bgs[props.type] || bgs.info;
});

const textClass = computed(() => {
    const texts = {
        success: 'text-emerald-900',
        error: 'text-red-900',
        warning: 'text-amber-900',
        info: 'text-blue-900',
    };
    return texts[props.type] || texts.info;
});

const iconPath = computed(() => {
    const paths = {
        success: 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z',
        error: 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z',
        warning: 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 0 1-1-1V6a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1Z',
        info: 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a6.5 6.5 0 1 1 0-13 6.5 6.5 0 0 1 0 13Zm.75-11.25a.75.75 0 0 0-1.5 0v4.26a.75.75 0 0 0 1.5 0V5.25Zm0 8a.75.75 0 1 0-1.5 0 .75.75 0 0 0 1.5 0Z',
    };
    return paths[props.type] || paths.info;
});

onMounted(() => {
    if (props.duration > 0) {
        setTimeout(() => {
            isVisible.value = false;
            emit('close');
        }, props.duration);
    }
});

const close = () => {
    isVisible.value = false;
    emit('close');
};
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-2"
    >
        <div
            v-if="isVisible"
            :class="[
                'fixed top-4 right-4 z-50 flex items-start gap-3 max-w-sm p-4 rounded-base border',
                bgClass,
            ]"
            role="alert"
        >
            <svg :class="['w-5 h-5 flex-shrink-0 mt-0.5', iconClass]" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path :d="iconPath" />
            </svg>
            <div class="flex-1">
                <p :class="['text-sm font-medium', textClass]">
                    {{ message }}
                </p>
            </div>
            <button
                @click="close"
                :class="['text-gray-400 hover:text-gray-600 flex-shrink-0']"
                aria-label="Close"
            >
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </Transition>
</template>

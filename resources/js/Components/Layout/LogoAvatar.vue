<script setup>
import { ref } from 'vue';

defineProps({
    src: { type: String, default: '' },
    alt: { type: String, default: 'Avatar' },
    fallback: { type: String, default: 'D' },
});

const failed = ref(false);

function onError() {
    failed.value = true;
}
</script>

<template>
    <div class="w-10 h-10 rounded-full overflow-hidden border border-border dark:border-border-dark bg-primary flex items-center justify-center text-white font-mono text-sm font-bold shrink-0 transition-transform duration-200 hover:scale-105">
        <img
            v-if="src && !failed"
            :src="src"
            :alt="alt"
            class="w-full h-full object-cover"
            @error="onError"
        />
        <span v-else>{{ fallback }}</span>
    </div>
</template>

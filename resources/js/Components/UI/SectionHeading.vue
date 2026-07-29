<script setup>
defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    align: { type: String, default: 'left' },
});
</script>

<template>
    <div :class="align === 'center' ? 'text-center' : 'text-left'">
        <p
            v-if="eyebrow"
            class="font-mono text-xs uppercase tracking-widest text-primary mb-2"
        >
            {{ eyebrow }}
        </p>
        <h2 class="text-3xl sm:text-4xl font-bold text-ink dark:text-white">
            {{ title }}
        </h2>
    </div>
</template>

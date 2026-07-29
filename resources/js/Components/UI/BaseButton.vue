<script setup>
defineProps({
    variant: {
        type: String,
        default: 'primary',
    },
    as: {
        type: [String, Object, Function],
        default: 'button',
    },
});
</script>

<template>
    <component
        :is="as"
        class="inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-sm font-semibold transition-all duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:opacity-50 disabled:pointer-events-none"
        :class="{
            'bg-primary text-white hover:bg-primary-dark shadow-md shadow-primary/20': variant === 'primary',
            'border border-border dark:border-border-dark text-ink dark:text-white hover:border-primary hover:text-primary dark:hover:text-primary': variant === 'secondary',
            'text-ink-light dark:text-white/70 hover:text-primary dark:hover:text-primary': variant === 'ghost',
        }"
    >
        <slot />
    </component>
</template>

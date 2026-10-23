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
        class="inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-sm font-semibold transition-[background-color,color,border-color,box-shadow,transform] duration-200 ease-out hover:-translate-y-px active:translate-y-0 active:scale-[0.98] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:opacity-50 disabled:pointer-events-none motion-reduce:transform-none"
        :class="{
            'bg-primary text-white hover:bg-primary-dark shadow-sm shadow-primary/25 hover:shadow-md hover:shadow-primary/30': variant === 'primary',
            'border border-border dark:border-border-dark text-ink dark:text-white hover:border-primary hover:text-primary dark:hover:text-primary': variant === 'secondary',
            'text-ink-light dark:text-white/70 hover:text-primary dark:hover:text-primary': variant === 'ghost',
        }"
    >
        <slot />
    </component>
</template>

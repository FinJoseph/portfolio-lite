<script setup>
import { computed } from 'vue';

const props = defineProps({
    eyebrow: { type: String, default: '' },
    title: { type: String, required: true },
    align: { type: String, default: 'left' },
    as: { type: String, default: 'h2' },
});

const size = computed(() => (props.as === 'h1' ? 'text-h1' : 'text-h2'));

const tag = computed(() => {
    const allowed = ['h1', 'h2', 'h3'];

    return allowed.includes(props.as) ? props.as : 'h2';
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
        <component :is="tag" :class="[size, 'font-bold text-ink dark:text-white']">
            {{ title }}
        </component>
    </div>
</template>

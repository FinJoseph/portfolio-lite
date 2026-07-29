<script setup>
import { onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    json: {
        type: Object,
        required: true,
    },
});

let scriptEl = null;

function inject() {
    if (typeof document === 'undefined') {
        return;
    }

    if (scriptEl) {
        scriptEl.remove();
    }

    scriptEl = document.createElement('script');
    scriptEl.type = 'application/ld+json';
    scriptEl.textContent = JSON.stringify(props.json);
    scriptEl.setAttribute('data-json-ld', '');
    document.head.appendChild(scriptEl);
}

onMounted(inject);

watch(() => props.json, inject, { deep: true });

onUnmounted(() => {
    if (scriptEl) {
        scriptEl.remove();
    }
});
</script>

<template></template>

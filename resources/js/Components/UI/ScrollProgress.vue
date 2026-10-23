<script setup>
import { onMounted, onUnmounted, ref } from 'vue';

const bar = ref(null);

let frame = 0;

const read = () => {
    frame = 0;

    if (!bar.value) {
        return;
    }

    const doc = document.documentElement;
    const max = doc.scrollHeight - window.innerHeight;
    const progress = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0;

    bar.value.style.transform = `scaleX(${progress})`;
};

const onScroll = () => {
    if (frame) {
        return;
    }

    frame = requestAnimationFrame(read);
};

onMounted(() => {
    read();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
    window.removeEventListener('resize', onScroll);

    if (frame) {
        cancelAnimationFrame(frame);
    }
});
</script>

<template>
    <Teleport to="body">
        <!-- Progression de lecture : purement décorative -->
        <div
            class="pointer-events-none fixed inset-x-0 top-0 z-[70] h-0.5"
            aria-hidden="true"
        >
            <div
                ref="bar"
                class="h-full origin-left bg-gradient-to-r from-primary via-primary-light to-accent"
                style="transform: scaleX(0)"
            ></div>
        </div>
    </Teleport>
</template>

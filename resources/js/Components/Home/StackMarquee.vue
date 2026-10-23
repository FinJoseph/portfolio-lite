<script setup>
import { computed } from 'vue';

const props = defineProps({
    skills: { type: Array, default: () => [] },
});

/**
 * Bandeau de stack : les technos réellement pratiquées, triées par niveau.
 * Les savoir-être (soft_skills) sont exclus : ce sont des mots, pas des outils.
 */
const items = computed(() => {
    const real = props.skills.filter(
        (skill) => skill.category !== 'soft_skills' && skill.name
    );

    return [...real]
        .sort((a, b) => (b.level ?? 0) - (a.level ?? 0))
        .slice(0, 14)
        .map((skill) => skill.name);
});

// 6 copies : la piste reste plus large que la fenêtre visible, même en 4K
// (une copie ≈ 830 px avec 6 technos). La boucle se fait sur -1/6 de la piste.
const loop = computed(() => Array.from({ length: 6 }, () => items.value).flat());
</script>

<template>
    <div
        v-if="items.length"
        class="relative overflow-hidden border-y border-border/60 dark:border-border-dark/60 bg-white/40 dark:bg-white/[0.02] py-5 [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]"
        aria-hidden="true"
    >
        <div
            class="marquee flex w-max items-center whitespace-nowrap motion-reduce:animate-none"
        >
            <span
                v-for="(name, index) in loop"
                :key="index"
                class="flex items-center gap-4 pr-10 font-mono text-sm uppercase tracking-widest text-ink-light/70 dark:text-white/45"
            >
                {{ name }}
                <span class="h-1 w-1 rounded-full bg-primary/60"></span>
            </span>
        </div>
    </div>
</template>

<style scoped>
.marquee {
    animation: marquee 42s linear infinite;
}

.marquee:hover {
    animation-play-state: paused;
}

@keyframes marquee {
    from {
        transform: translate3d(0, 0, 0);
    }

    to {
        transform: translate3d(-16.6667%, 0, 0);
    }
}

@media (prefers-reduced-motion: reduce) {
    .marquee {
        animation: none;
        transform: none;
    }
}
</style>

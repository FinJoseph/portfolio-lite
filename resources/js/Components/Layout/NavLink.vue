<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    href: { type: String, required: true },
    // Nom du composant Inertia correspondant à ce lien (ex: 'Home', 'Skills/Index')
    pageName: { type: String, required: true },
    variant: { type: String, default: 'desktop' }, // 'desktop' | 'mobile'
});

const page = usePage();
const isActive = computed(() => page.component === props.pageName);

const base = 'font-bold transition-colors duration-200';

const sizing = computed(() =>
    props.variant === 'mobile'
        ? 'block px-4 py-2.5 text-sm rounded-xl'
        : 'px-3 py-1.5 text-sm rounded-full'
);

// Lien inactif : gris discret, verdit légèrement au survol
const idleClasses = 'text-ink-light dark:text-white/70 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-black/5 dark:hover:bg-white/5';

// Lien actif : texte vert + léger fond vert transparent, AUCUNE bordure
const activeClasses = 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10';
</script>

<template>
    <Link :href="href" :class="[base, sizing, isActive ? activeClasses : idleClasses]">
        <slot />
    </Link>
</template>
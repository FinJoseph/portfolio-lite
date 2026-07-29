<script setup>
import { useDarkMode } from '@/composables/useDarkMode';

const { isDark, toggle } = useDarkMode();
</script>

<template>
    <button
        @click="toggle"
        class="flex items-center justify-center w-10 h-10 rounded-full border border-border dark:border-border-dark text-ink-light dark:text-white/70 hover:border-primary hover:text-primary dark:hover:text-primary transition-colors"
        :aria-label="isDark ? 'Mode clair' : 'Mode sombre'"
    >
        <svg v-if="isDark" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
        <svg v-else class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
    </button>
</template>

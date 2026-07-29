<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { router } from '@inertiajs/vue3';

const { locale } = useI18n();
const showTooltip = ref(false);

const locales = ['fr', 'en', 'mg'];
const labels = { fr: 'FR', en: 'EN', mg: 'MG' };
const fullLabels = { fr: 'Français', en: 'English', mg: 'Malagasy' };

function cycleLocale() {
    const currentIndex = locales.indexOf(locale.value);
    const nextIndex = (currentIndex + 1) % locales.length;
    const code = locales[nextIndex];

    locale.value = code;

    // Persiste la locale dans un cookie pour que le middleware SetLocale
    // puisse la lire au prochain refresh (et sur le premier rendu SSR).
    document.cookie = `locale=${code}; path=/; max-age=31536000; samesite=lax`;

    router.get(
        window.location.pathname,
        {},
        { headers: { 'X-Locale': code }, preserveScroll: true }
    );
}
</script>

<template>
    <div class="relative flex flex-col items-center">
        <button
            type="button"
            @click="cycleLocale"
            @mouseenter="showTooltip = true"
            @mouseleave="showTooltip = false"
            class="flex items-center gap-1.5 pl-3 pr-4 h-10 rounded-full border border-border dark:border-border-dark bg-white dark:bg-ink-light/50 text-xs font-mono font-bold uppercase tracking-wider text-ink dark:text-white hover:border-primary hover:text-primary dark:hover:text-primary transition-all duration-200 hover:scale-105 active:scale-95"
            :aria-label="`Langue actuelle : ${fullLabels[locale.value]}. Cliquer pour changer.`"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            {{ labels[locale.value] }}
        </button>

        <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div
                v-show="showTooltip"
                class="absolute top-full mt-2 px-2 py-1 rounded-lg bg-ink dark:bg-white text-white dark:text-ink text-[10px] font-medium whitespace-nowrap shadow-lg z-50"
            >
                Changer de langue
                <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-ink dark:bg-white rotate-45"></div>
            </div>
        </transition>
    </div>
</template>

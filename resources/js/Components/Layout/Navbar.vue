<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import LocaleSwitcher from './LocaleSwitcher.vue';
import DarkModeToggle from './DarkModeToggle.vue';
import NavDropdown from './NavDropdown.vue';
import NavLink from './NavLink.vue';
import LogoAvatar from './LogoAvatar.vue';

const { t } = useI18n();
const page = usePage();
const mobileOpen = ref(false);

const current = computed(() => page.component ?? '');
const isActiveIn = (names) => names.includes(current.value);

// Pages regroupées sous le dropdown "Réalisations" — définies une seule fois,
// réutilisées pour le calcul "actif" du dropdown ET pour générer ses liens.
const workLinks = [
    { pageName: 'Skills/Index', href: '/skills', labelKey: 'nav.skills' },
    { pageName: 'Projects/Index', href: '/projects', labelKey: 'nav.projects' },
    { pageName: 'Testimonials', href: '/testimonials', labelKey: 'nav.testimonials' },
];
</script>

<template>
    <div class="fixed top-4 left-0 right-0 z-50 px-4 sm:px-6 pointer-events-none">
        <nav class="pointer-events-auto max-w-5xl mx-auto flex items-center justify-between rounded-full border border-border/60 dark:border-border-dark/60 bg-white/85 dark:bg-ink/85 backdrop-blur-xl shadow-2xl shadow-black/10 dark:shadow-black/40 px-2 py-2 transition-all duration-300">
            <Link href="/" class="pl-1 flex items-center gap-3 group">
                <LogoAvatar src="/images/settings/avatar.jpg" alt="Logo" fallback="D" />
                <span class="hidden sm:block font-mono text-sm font-bold text-ink dark:text-white tracking-tight group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-200" />
            </Link>

            <!-- Desktop -->
            <div class="hidden md:flex items-center gap-1">
                <NavLink href="/" page-name="Home">{{ t('nav.home') }}</NavLink>
                <NavLink href="/about" page-name="About">{{ t('nav.about') }}</NavLink>

                <NavDropdown :label="t('nav.work')" :active="isActiveIn(workLinks.map(l => l.pageName))">
                    <NavLink
                        v-for="link in workLinks"
                        :key="link.pageName"
                        :href="link.href"
                        :page-name="link.pageName"
                        variant="mobile"
                        class="mx-1"
                    >
                        {{ t(link.labelKey) }}
                    </NavLink>
                </NavDropdown>

                <NavLink href="/blog" page-name="Blog/Index">{{ t('nav.blog') }}</NavLink>

                <Link
                    href="/contact"
                    class="ml-1 text-sm font-bold transition-all duration-200 px-4 py-1.5 rounded-full text-white bg-primary shadow-md shadow-primary/30 hover:bg-primary-dark hover:shadow-lg hover:shadow-primary/40 hover:scale-105 active:scale-95"
                >
                    {{ t('nav.contact') }}
                </Link>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 pr-1">
                <LocaleSwitcher />
                <DarkModeToggle />

                <button
                    type="button"
                    class="md:hidden p-2 rounded-full text-ink-light dark:text-white/70 hover:bg-black/5 dark:hover:bg-white/10 transition-colors"
                    :aria-label="mobileOpen ? 'Fermer' : 'Menu'"
                    @click="mobileOpen = !mobileOpen"
                >
                    <svg v-if="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </nav>

        <!-- Mobile -->
        <div
            v-show="mobileOpen"
            class="pointer-events-auto md:hidden mt-2 max-w-5xl mx-auto rounded-2xl border border-border/60 dark:border-border-dark/60 bg-white/90 dark:bg-ink/90 backdrop-blur-md shadow-2xl p-2 space-y-1"
        >
            <NavLink href="/" page-name="Home" variant="mobile" @click="mobileOpen = false">{{ t('nav.home') }}</NavLink>
            <NavLink href="/about" page-name="About" variant="mobile" @click="mobileOpen = false">{{ t('nav.about') }}</NavLink>
            <NavLink
                v-for="link in workLinks"
                :key="link.pageName"
                :href="link.href"
                :page-name="link.pageName"
                variant="mobile"
                @click="mobileOpen = false"
            >
                {{ t(link.labelKey) }}
            </NavLink>
            <NavLink href="/blog" page-name="Blog/Index" variant="mobile" @click="mobileOpen = false">{{ t('nav.blog') }}</NavLink>

            <Link
                href="/contact"
                class="block text-center text-sm font-bold px-4 py-2.5 rounded-xl text-white bg-primary hover:bg-primary-dark transition-colors shadow-md shadow-primary/20"
                @click="mobileOpen = false"
            >
                {{ t('nav.contact') }}
            </Link>
        </div>
    </div>
</template>
<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const year = new Date().getFullYear();
const settings = usePage().props.settings ?? {};

const socialLinks = settings.social_links ?? {};
const activeSocials = Object.entries(socialLinks).filter(([, url]) => Boolean(url));

const navLinks = [
    { label: t('nav.home'), href: '/' },
    { label: t('nav.about'), href: '/about' },
    { label: t('nav.skills'), href: '/skills' },
    { label: t('nav.projects'), href: '/projects' },
    { label: t('nav.blog'), href: '/blog' },
    { label: t('nav.testimonials'), href: '/testimonials' },
];

const techStack = [
    { name: 'Laravel', color: 'hover:text-red-500' },
    { name: 'Vue.js', color: 'hover:text-emerald-500' },
    { name: 'Tailwind CSS', color: 'hover:text-cyan-500' },
    { name: 'Inertia.js', color: 'hover:text-violet-500' },
];

// Back to top
const showBackToTop = ref(false);
const handleScroll = () => {
    showBackToTop.value = window.scrollY > 600;
};
const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
});
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

// Copy email to clipboard
const emailCopied = ref(false);
const copyEmail = async () => {
    if (!settings.email) return;
    try {
        await navigator.clipboard.writeText(settings.email);
        emailCopied.value = true;
        setTimeout(() => {
            emailCopied.value = false;
        }, 2000);
    } catch (err) {
        // Fallback: open mailto if clipboard fails
        window.location.href = `mailto:${settings.email}`;
    }
};

const hasContact = computed(() => Boolean(settings.email || settings.phone));
</script>

<template>
    <footer
        class="relative mt-24 border-t border-border dark:border-border-dark overflow-hidden"
    >
        <div class="relative max-w-6xl mx-auto px-6 pt-16 pb-8">
            <!-- Top section: 4-column grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                <!-- Brand column -->
                <div class="space-y-5 sm:col-span-2 lg:col-span-1">
                    <Link
                        href="/"
                        class="inline-flex items-center gap-2 text-lg font-semibold tracking-tight text-ink dark:text-white hover:text-amber dark:hover:text-amber transition-colors duration-300"
                    >
                        <span
                            class="inline-block w-2 h-2 rounded-full bg-amber animate-pulse"
                            aria-hidden="true"
                        ></span>
                        {{ settings.site_name || 'Portfolio' }}
                    </Link>
                    <p class="text-sm text-muted leading-relaxed max-w-xs">
                        {{ settings.hero_tagline || t('footer.tagline') }}
                    </p>
                    <div v-if="activeSocials.length" class="flex items-center gap-2 pt-2">
                        <a
                            v-for="[name, url] in activeSocials"
                            :key="name"
                            :href="url"
                            target="_blank"
                            rel="noopener noreferrer"
                            :aria-label="name"
                            class="group relative inline-flex items-center justify-center w-9 h-9 rounded-full border border-border dark:border-border-dark text-muted hover:text-white dark:hover:text-white transition-all duration-300 hover:-translate-y-0.5 hover:scale-110 hover:border-amber hover:shadow-lg hover:shadow-amber/30 dark:hover:shadow-amber/20 hover:bg-amber"
                        >
                            <svg
                                v-if="name === 'github'"
                                class="w-4 h-4 transition-transform duration-300 group-hover:rotate-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <svg
                                v-else-if="name === 'linkedin'"
                                class="w-4 h-4 transition-transform duration-300 group-hover:rotate-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                                />
                            </svg>
                            <svg
                                v-else-if="name === 'twitter' || name === 'x'"
                                class="w-4 h-4 transition-transform duration-300 group-hover:rotate-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
                                />
                            </svg>
                            <svg
                                v-else
                                class="w-4 h-4 transition-transform duration-300 group-hover:rotate-6"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation column -->
                <div class="space-y-5">
                    <h3
                        class="text-xs font-mono uppercase tracking-[0.2em] text-ink dark:text-white font-semibold"
                    >
                        {{ t('footer.navigation') }}
                    </h3>
                    <ul class="space-y-3">
                        <li v-for="link in navLinks" :key="link.href">
                            <Link
                                :href="link.href"
                                class="group relative inline-flex items-center text-sm text-muted hover:text-ink dark:hover:text-white transition-colors duration-300"
                            >
                                <span class="relative">
                                    {{ link.label }}
                                    <span
                                        class="absolute left-0 -bottom-0.5 h-px w-0 bg-amber group-hover:w-full transition-all duration-300 ease-out"
                                    ></span>
                                </span>
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Tech stack column -->
                <div class="space-y-5">
                    <h3
                        class="text-xs font-mono uppercase tracking-[0.2em] text-ink dark:text-white font-semibold"
                    >
                        {{ t('footer.tech_stack') }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="tech in techStack"
                            :key="tech.name"
                            :class="[
                                'inline-flex items-center px-3 py-1.5 rounded-full text-xs font-mono bg-paper-darker/50 dark:bg-paper-dark/50 border border-border dark:border-border-dark text-muted transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-default',
                                tech.color,
                            ]"
                        >
                            {{ tech.name }}
                        </span>
                    </div>
                </div>

                <!-- Contact column -->
                <div class="space-y-5">
                    <h3
                        class="text-xs font-mono uppercase tracking-[0.2em] text-ink dark:text-white font-semibold"
                    >
                        {{ t('footer.contact') }}
                    </h3>

                    <div
                        v-if="hasContact"
                        class="relative p-5 rounded-2xl border border-border dark:border-border-dark bg-white/60 dark:bg-ink/30 backdrop-blur-md shadow-sm hover:shadow-lg hover:border-amber/40 transition-all duration-500 group"
                    >
                        <div
                            class="absolute inset-0 rounded-2xl bg-gradient-to-br from-amber/5 to-teal/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"
                            aria-hidden="true"
                        ></div>
                        <div class="relative space-y-3">
                            <button
                                v-if="settings.email"
                                type="button"
                                @click="copyEmail"
                                class="group/email flex items-start gap-3 w-full text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-amber rounded-md"
                                :aria-label="t('footer.copy_email')"
                            >
                                <span
                                    class="flex-shrink-0 mt-0.5 inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber/10 text-amber group-hover/email:bg-amber group-hover/email:text-white transition-all duration-300"
                                >
                                    <svg
                                        v-if="!emailCopied"
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                                        />
                                    </svg>
                                    <svg
                                        v-else
                                        class="w-4 h-4 animate-[ping_0.4s_ease-out]"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5"
                                        />
                                    </svg>
                                </span>
                                <span class="flex-1 min-w-0">
                                    <span
                                        class="block text-sm font-medium text-ink dark:text-white group-hover/email:text-amber transition-colors duration-300 truncate"
                                    >
                                        {{ settings.email }}
                                    </span>
                                    <span
                                        class="block text-xs text-muted mt-0.5 transition-opacity duration-300"
                                        :class="emailCopied ? 'opacity-100 text-amber' : 'opacity-70'"
                                    >
                                        {{ emailCopied ? t('footer.copied') : t('footer.copy_hint') }}
                                    </span>
                                </span>
                            </button>

                            <div
                                v-if="settings.phone"
                                class="flex items-center gap-3 text-sm text-muted"
                            >
                                <span
                                    class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-lg bg-teal/10 text-teal"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"
                                        />
                                    </svg>
                                </span>
                                <a
                                    :href="`tel:${settings.phone.replace(/\s/g, '')}`"
                                    class="hover:text-ink dark:hover:text-white transition-colors duration-300"
                                >
                                    {{ settings.phone }}
                                </a>
                            </div>

                            <div class="flex items-center gap-2 text-xs text-muted pt-1">
                                <svg
                                    class="w-3.5 h-3.5 text-amber"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
                                    />
                                </svg>
                                <span>{{ t('footer.location') }}</span>
                            </div>
                        </div>
                    </div>

                    <Link
                        v-else
                        href="/contact"
                        class="inline-flex items-center gap-2 text-sm text-amber hover:gap-3 transition-all duration-300"
                    >
                        {{ t('footer.connect_cta') }}
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Bottom section -->
            <div
                class="mt-14 pt-8 border-t border-border dark:border-border-dark flex flex-col sm:flex-row items-center justify-between gap-4"
            >
                <p
                    class="text-xs text-muted font-mono text-center sm:text-left"
                >
                    © {{ year }} {{ settings.site_name || 'Portfolio' }} — {{ t('footer.rights') }}
                </p>
                <p
                    class="text-xs text-muted font-mono text-center sm:text-right"
                >
                    {{ t('footer.crafted_with') }}
                </p>
            </div>
        </div>

        <!-- Back to top button -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 translate-y-4 scale-90"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-90"
        >
            <button
                v-if="showBackToTop"
                type="button"
                @click="scrollToTop"
                :aria-label="t('footer.back_to_top')"
                class="fixed bottom-6 right-6 z-50 inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber/90 text-white shadow-sm shadow-amber/15 hover:shadow-md hover:shadow-amber/25 focus:outline-none focus-visible:ring-1 focus-visible:ring-amber focus-visible:ring-offset-1 transition-all duration-300 group"
            >
                <svg
                    class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-0.5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 15.75l7.5-7.5 7.5 7.5"
                    />
                </svg>
            </button>
        </Transition>
    </footer>
</template>

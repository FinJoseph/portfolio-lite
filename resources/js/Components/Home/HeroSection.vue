<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();
const settings = usePage().props.settings ?? {};

const siteName = computed(() => settings.site_name || 'Portfolio');
const avatar = computed(() => settings.avatar || null);
const socialLinks = computed(() => settings.social_links ?? {});
const activeSocials = computed(() =>
    Object.entries(socialLinks.value).filter(([, url]) => Boolean(url))
);

const headline = computed(() =>
    (settings.hero_headline || 'Hi, I\'m [name]').replace(/\[name\]/g, siteName.value)
);
const tagline = computed(() => settings.hero_tagline || '');
const description = computed(() => settings.hero_description || '');
const ctaPrimary = computed(() => settings.hero_cta_primary || t('home.hero.cta_primary'));
const ctaSecondary = computed(() => settings.hero_cta_secondary || t('home.hero.cta_secondary'));
const availabilityBadge = computed(() => settings.availability_badge || '');

const firstName = computed(() => siteName.value.split(' ')[0]);

const mounted = ref(false);
onMounted(() => {
    requestAnimationFrame(() => {
        mounted.value = true;
    });
});

function staggerClass(index) {
    return mounted.value
        ? 'opacity-100 translate-y-0'
        : 'opacity-0 translate-y-4';
}
</script>

<template>
    <section
        class="relative min-h-[calc(100vh-7rem)] flex items-center overflow-hidden"
    >
        <div
            class="relative w-full max-w-7xl mx-auto px-6 py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center"
        >
            <!-- Left column: text -->
            <div class="order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left">
                <!-- Availability badge -->
                <div
                    v-if="availabilityBadge"
                    class="transition-all duration-700 ease-out"
                    :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', 'delay-[100ms]']"
                >
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 dark:bg-primary/15 border border-primary/20 text-primary text-xs sm:text-sm font-mono font-medium"
                    >
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full rounded-full bg-primary opacity-75 animate-ping"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-primary"></span>
                        </span>
                        {{ availabilityBadge }}
                    </span>
                </div>

                <!-- Headline -->
                <h1
                    class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-ink dark:text-white transition-all duration-700 ease-out"
                    :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', 'delay-[200ms]']"
                >
                    {{ headline }}
                </h1>

                <!-- Tagline -->
                <p
                    v-if="tagline"
                    class="mt-4 text-lg sm:text-xl text-primary font-medium transition-all duration-700 ease-out"
                    :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', 'delay-[300ms]']"
                >
                    {{ tagline }}
                </p>

                <!-- Description -->
                <p
                    v-if="description"
                    class="mt-4 text-sm sm:text-base text-ink-light dark:text-white/70 max-w-lg leading-relaxed transition-all duration-700 ease-out"
                    :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', 'delay-[400ms]']"
                >
                    {{ description }}
                </p>

                <!-- CTAs -->
                <div
                    class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-3 transition-all duration-700 ease-out"
                    :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', 'delay-[500ms]']"
                >
                    <BaseButton :as="Link" href="/projects" variant="primary">
                        {{ ctaPrimary }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </BaseButton>
                    <BaseButton :as="Link" href="/contact" variant="secondary">
                        {{ ctaSecondary }}
                    </BaseButton>
                </div>

                <!-- Social icons -->
                <div
                    v-if="activeSocials.length"
                    class="mt-8 flex items-center justify-center lg:justify-start gap-2 transition-all duration-700 ease-out"
                    :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', 'delay-[600ms]']"
                >
                    <span class="text-[10px] sm:text-xs font-mono uppercase tracking-widest text-muted mr-2">
                        {{ t('home.hero.follow_me') }}
                    </span>
                    <a
                        v-for="[name, url] in activeSocials"
                        :key="name"
                        :href="url"
                        target="_blank"
                        rel="noopener noreferrer"
                        :aria-label="name"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-border dark:border-border-dark text-muted hover:text-primary hover:border-primary hover:-translate-y-0.5 transition-all duration-300"
                    >
                        <svg
                            v-if="name === 'github'"
                            class="w-3.5 h-3.5"
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
                            class="w-3.5 h-3.5"
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
                            class="w-3.5 h-3.5"
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
                            class="w-3.5 h-3.5"
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

            <!-- Right column: image/avatar -->
            <div class="order-1 lg:order-2 flex items-center justify-center">
                <div
                    class="relative w-64 h-64 sm:w-72 sm:h-72 lg:w-80 lg:h-80 transition-all duration-1000 ease-out"
                    :class="mounted ? 'opacity-100 scale-100' : 'opacity-0 scale-90'"
                >
                    <!-- Rotating ring -->
                    <div
                        class="absolute inset-0 rounded-full border-2 border-dashed border-primary/30 animate-[spin_20s_linear_infinite]"
                        aria-hidden="true"
                    ></div>
                    <!-- Gradient blob -->
                    <div
                        class="absolute -inset-4 rounded-full bg-gradient-to-br from-primary/25 via-primary-light/15 to-transparent blur-2xl animate-[pulse_4s_ease-in-out_infinite]"
                        aria-hidden="true"
                    ></div>
                    <!-- Floating avatar -->
                    <div
                        class="relative w-full h-full rounded-full overflow-hidden bg-gradient-to-br from-primary/20 to-primary-light/20 border-2 border-primary/30 shadow-2xl shadow-primary/20 animate-[float_4s_ease-in-out_infinite]"
                    >
                        <img
                            v-if="avatar"
                            :src="avatar"
                            :alt="siteName"
                            class="w-full h-full object-cover"
                            loading="eager"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-primary-dark text-white text-6xl sm:text-7xl font-bold"
                        >
                            {{ firstName.charAt(0).toUpperCase() }}
                        </div>
                    </div>
                    <!-- Status dot -->
                    <span class="absolute top-3 right-3 flex h-5 w-5">
                        <span
                            class="absolute inline-flex h-full w-full rounded-full bg-primary opacity-70 animate-ping"
                        ></span>
                        <span
                            class="relative inline-flex rounded-full h-5 w-5 bg-primary border-2 border-paper dark:border-paper-dark"
                        ></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div
            class="hidden sm:flex absolute bottom-3 left-1/2 -translate-x-1/2 flex-col items-center gap-1.5 text-muted transition-all duration-700 ease-out"
            :class="mounted ? 'opacity-100' : 'opacity-0'"
        >
            <span class="text-[10px] font-mono uppercase tracking-widest">{{ t('home.hero.scroll') }}</span>
            <span class="w-px h-6 bg-gradient-to-b from-primary to-transparent animate-[float_2s_ease-in-out_infinite]"></span>
        </div>
    </section>
</template>

<style scoped>
@keyframes float {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-12px);
    }
}
</style>

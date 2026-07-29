<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, onBeforeUnmount, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';

const { t, locale } = useI18n();

const props = defineProps({
    experiences: { type: Array, default: () => [] },
    education: { type: Array, default: () => [] },
});

const settings = computed(() => usePage().props.settings ?? {});

const siteName = computed(() => settings.value.site_name || 'Portfolio');
const avatar = computed(() => settings.value.avatar || null);
const jobTitle = computed(() => settings.value.job_title?.[locale.value] || settings.value.job_title || '');
const bio = computed(() => settings.value.bio?.[locale.value] || settings.value.bio || '');
const availability = computed(() => settings.value.availability_badge?.[locale.value] || '');
const socialLinks = computed(() => settings.value.social_links ?? {});
const email = computed(() => settings.value.email || '');
const phone = computed(() => settings.value.phone || '');

const activeSocials = computed(() =>
    Object.entries(socialLinks.value).filter(([, url]) => Boolean(url))
);

const initials = computed(() => {
    const parts = siteName.value.trim().split(/\s+/);
    if (parts.length === 0) return '?';
    if (parts.length === 1) return parts[0].charAt(0).toUpperCase();
    return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
});

const sortedExperiences = computed(() =>
    [...props.experiences].sort((a, b) => (a.order || 99) - (b.order || 99))
);

const sortedEducation = computed(() =>
    [...props.education].sort((a, b) => (a.order || 99) - (b.order || 99))
);

const totalYears = computed(() => {
    if (!props.experiences.length) return 0;
    const years = props.experiences.map(e => {
        if (e.start_date) return parseInt(e.start_date.slice(0, 4));
        return null;
    }).filter(Boolean);
    return years.length ? new Date().getFullYear() - Math.min(...years) : 0;
});

const visibleSections = ref({ hero: false, exp: false, edu: false });
const counterValues = ref({ years: 0, experiences: 0, education: 0 });
const countersStarted = ref(false);

const observer = ref(null);

function observeSection(el, key) {
    if (!el) return;
    const obs = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                visibleSections.value[key] = true;
                if (key === 'hero' && !countersStarted.value) {
                    countersStarted.value = true;
                    animateCounters();
                }
                obs.unobserve(entry.target);
            }
        },
        { threshold: 0.2 }
    );
    obs.observe(el);
    observer.value = obs;
}

function animateCounters() {
    const targets = {
        years: totalYears.value,
        experiences: props.experiences.length,
        education: props.education.length,
    };
    const duration = 1500;
    const start = performance.now();
    function tick(now) {
        const pct = Math.min(1, (now - start) / duration);
        const eased = 1 - Math.pow(1 - pct, 3);
        counterValues.value.years = Math.round(targets.years * eased);
        counterValues.value.experiences = Math.round(targets.experiences * eased);
        counterValues.value.education = Math.round(targets.education * eased);
        if (pct < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
}

onMounted(() => {
    const heroEl = document.getElementById('hero-section');
    if (heroEl) observeSection(heroEl, 'hero');
    const expEl = document.getElementById('experience-section');
    if (expEl) observeSection(expEl, 'exp');
    const eduEl = document.getElementById('education-section');
    if (eduEl) observeSection(eduEl, 'edu');
});

onBeforeUnmount(() => {
    if (observer.value) observer.value.disconnect();
});

function locVal(obj) {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;
    return obj[locale.value] || obj.en || obj.fr || '';
}
</script>

<template>
    <Head :title="t('meta.about.title', 'À propos')" />
    <AppLayout>
        <!-- ==================== HERO ==================== -->
        <section
            id="hero-section"
            class="relative overflow-hidden"
        >
            <!-- Animated mesh background -->
            <div class="absolute inset-0 -z-10" aria-hidden="true">
                <div
                    class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-gradient-to-br from-primary/20 via-primary-light/10 to-transparent blur-[120px] animate-[meshMove_8s_ease-in-out_infinite]"
                ></div>
                <div
                    class="absolute -bottom-40 -left-40 w-[400px] h-[400px] rounded-full bg-gradient-to-tr from-violet-500/15 via-primary/10 to-transparent blur-[100px] animate-[meshMove_10s_ease-in-out_infinite_reverse]"
                ></div>
                <div
                    class="absolute top-1/2 left-1/3 w-[300px] h-[300px] rounded-full bg-gradient-to-r from-cyan-400/10 to-blue-500/10 blur-[80px] animate-[meshMove_12s_ease-in-out_infinite]"
                ></div>
            </div>

            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-20 lg:py-28">
                <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">
                    <!-- Avatar with creative frame -->
                    <div class="shrink-0">
                        <div class="relative w-40 h-40 sm:w-48 sm:h-48 lg:w-56 lg:h-56">
                            <!-- Rotating gradient ring -->
                            <svg
                                class="absolute -inset-2 w-[calc(100%+16px)] h-[calc(100%+16px)] animate-[spin_6s_linear_infinite]"
                                viewBox="0 0 100 100"
                                fill="none"
                            >
                                <defs>
                                    <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="var(--color-primary, #6366f1)" />
                                        <stop offset="50%" stop-color="var(--color-primary-light, #818cf8)" />
                                        <stop offset="100%" stop-color="var(--color-primary, #6366f1)" stop-opacity="0.3" />
                                    </linearGradient>
                                </defs>
                                <circle cx="50" cy="50" r="46" stroke="url(#ringGrad)" stroke-width="2" stroke-dasharray="80 120" stroke-linecap="round" />
                            </svg>
                            <!-- Glow -->
                            <div class="absolute -inset-6 rounded-full bg-primary/10 blur-3xl animate-[pulse_4s_ease-in-out_infinite]"></div>
                            <!-- Image -->
                            <div class="relative w-full h-full rounded-3xl overflow-hidden border-2 border-white/20 dark:border-white/10 shadow-2xl shadow-primary/20">
                                <img
                                    v-if="avatar"
                                    :src="avatar"
                                    :alt="siteName"
                                    class="w-full h-full object-cover"
                                    loading="eager"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-primary-light/10 text-5xl sm:text-6xl font-bold text-primary"
                                >
                                    {{ initials }}
                                </div>
                            </div>
                            <!-- Availability badge -->
                            <div
                                v-if="availability"
                                class="absolute -bottom-2 left-1/2 -translate-x-1/2 flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700/40 shadow-lg whitespace-nowrap"
                            >
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                <span class="w-2 h-2 rounded-full bg-emerald-400 absolute"></span>
                                <span class="text-xs font-medium text-emerald-700 dark:text-emerald-300">
                                    {{ availability }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Text -->
                    <div class="flex-1 text-center lg:text-left">
                        <h1
                            class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold text-ink dark:text-white leading-tight"
                        >
                            {{ siteName }}
                        </h1>
                        <div
                            v-if="jobTitle"
                            class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 dark:bg-primary/15 border border-primary/20"
                        >
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                            <span class="text-sm font-medium text-primary">{{ jobTitle }}</span>
                        </div>
                        <p
                            v-if="bio"
                            class="mt-5 text-base sm:text-lg text-ink-light dark:text-white/70 leading-relaxed max-w-2xl lg:mx-0 mx-auto"
                        >
                            {{ bio }}
                        </p>

                        <!-- Actions -->
                        <div class="mt-7 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                            <a
                                :href="`/cv/${locale}`"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-medium hover:bg-primary-dark hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 active:scale-95"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ t('about.download_cv', 'Télécharger CV') }}
                            </a>
                            <a
                                :href="`mailto:${email}`"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-border dark:border-border-dark text-ink-light dark:text-white/70 text-sm font-medium hover:border-primary hover:text-primary hover:bg-primary/5 transition-all duration-300"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ t('about.contact_me', 'Me contacter') }}
                            </a>
                        </div>

                        <!-- Social links -->
                        <div
                            v-if="activeSocials.length"
                            class="mt-6 flex items-center justify-center lg:justify-start gap-2"
                        >
                            <a
                                v-for="[name, url] in activeSocials"
                                :key="name"
                                :href="url"
                                target="_blank"
                                rel="noopener noreferrer"
                                :aria-label="name"
                                class="group relative flex items-center justify-center w-10 h-10 rounded-xl border border-border dark:border-border-dark text-muted hover:text-primary hover:border-primary hover:bg-primary/5 hover:-translate-y-0.5 transition-all duration-300"
                            >
                                <svg
                                    v-if="name === 'github'"
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <svg
                                    v-else-if="name === 'linkedin'"
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                                <span
                                    class="absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-0.5 rounded-md bg-ink dark:bg-white text-white dark:text-ink text-[10px] font-medium capitalize opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap"
                                >
                                    {{ name }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats row -->
                <div
                    v-if="visibleSections.hero"
                    class="mt-14 sm:mt-16 grid grid-cols-3 gap-4 sm:gap-6 max-w-lg mx-auto lg:mx-0"
                >
                    <div class="text-center p-4 rounded-xl bg-white/40 dark:bg-ink-light/20 border border-border/50 dark:border-border-dark/50 backdrop-blur-sm">
                        <div class="text-2xl sm:text-3xl font-bold text-primary tabular-nums">
                            {{ counterValues.years }}+
                        </div>
                        <div class="mt-1 text-xs text-ink-light dark:text-white/50 uppercase tracking-wider font-medium">
                            {{ t('about.stat_years', 'Années') }}
                        </div>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-white/40 dark:bg-ink-light/20 border border-border/50 dark:border-border-dark/50 backdrop-blur-sm">
                        <div class="text-2xl sm:text-3xl font-bold text-primary tabular-nums">
                            {{ counterValues.experiences }}
                        </div>
                        <div class="mt-1 text-xs text-ink-light dark:text-white/50 uppercase tracking-wider font-medium">
                            {{ t('about.stat_experiences', 'Expériences') }}
                        </div>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-white/40 dark:bg-ink-light/20 border border-border/50 dark:border-border-dark/50 backdrop-blur-sm">
                        <div class="text-2xl sm:text-3xl font-bold text-primary tabular-nums">
                            {{ counterValues.education }}
                        </div>
                        <div class="mt-1 text-xs text-ink-light dark:text-white/50 uppercase tracking-wider font-medium">
                            {{ t('about.stat_education', 'Diplômes') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== EXPERIENCES ==================== -->
        <section
            id="experience-section"
            class="max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-20 lg:py-24"
        >
            <SectionHeading
                :title="t('about.experience_title', 'Expériences')"
                align="center"
            />
            <p
                v-if="sortedExperiences.length"
                class="mt-2 text-center text-sm text-ink-light dark:text-white/50"
            >
                {{ sortedExperiences.length }} poste{{ sortedExperiences.length > 1 ? 's' : '' }}
            </p>

            <div v-if="sortedExperiences.length" class="mt-10 sm:mt-12 relative">
                <!-- Timeline line -->
                <div
                    class="absolute left-5 sm:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary/40 via-primary/20 to-transparent"
                    aria-hidden="true"
                ></div>

                <div class="space-y-10 sm:space-y-14">
                    <div
                        v-for="(exp, index) in sortedExperiences"
                        :key="`exp-${index}`"
                        class="relative transition-all duration-700 ease-out"
                        :class="visibleSections.exp ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        :style="{ transitionDelay: `${index * 150}ms` }"
                    >
                        <!-- Desktop: alternate left-right -->
                        <div class="flex flex-col sm:grid sm:grid-cols-2 gap-4 sm:gap-8">
                            <!-- Empty column for odd items on left (DESKTOP) -->
                            <div
                                v-if="index % 2 === 1"
                                class="hidden sm:block"
                            ></div>

                            <!-- Card -->
                            <div
                                class="relative sm:px-0"
                                :class="index % 2 === 0 ? 'sm:pr-10' : 'sm:pl-10'"
                            >
                                <!-- Timeline dot -->
                                <div
                                    class="absolute top-2 -left-5 sm:left-auto w-4 h-4 rounded-full bg-primary border-4 border-paper dark:border-paper-dark shadow-md shadow-primary/20 z-10"
                                    :class="index % 2 === 0 ? 'sm:right-[-10px]' : 'sm:left-[-10px]'"
                                    style="transform: translateX(-50%);"
                                ></div>
                                <!-- Mobile dot on left -->
                                <div
                                    class="sm:hidden absolute top-2 -left-5 w-4 h-4 rounded-full bg-primary border-4 border-paper dark:border-paper-dark shadow-md shadow-primary/20 z-10"
                                    style="transform: translateX(-50%);"
                                ></div>

                                <div
                                    class="group relative rounded-2xl border border-border dark:border-border-dark bg-white/60 dark:bg-ink-light/20 p-6 hover:border-primary/40 hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-0.5 transition-all duration-500"
                                >
                                    <!-- Hover accent bar -->
                                    <div
                                        class="absolute left-0 top-0 bottom-0 w-1 bg-primary rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                    ></div>

                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base sm:text-lg font-bold text-ink dark:text-white group-hover:text-primary transition-colors duration-300">
                                                {{ locVal(exp.title) }}
                                            </h3>
                                            <p class="mt-0.5 text-sm text-primary font-medium">
                                                {{ locVal(exp.company) }}
                                            </p>
                                        </div>
                                        <span
                                            v-if="exp.duration"
                                            class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-primary/5 border border-primary/10 text-[11px] font-mono text-muted"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                <line x1="16" y1="2" x2="16" y2="6"/>
                                                <line x1="8" y1="2" x2="8" y2="6"/>
                                                <line x1="3" y1="10" x2="21" y2="10"/>
                                            </svg>
                                            {{ exp.duration }}
                                        </span>
                                    </div>

                                    <p
                                        v-if="exp.description"
                                        class="text-sm text-ink-light dark:text-white/70 leading-relaxed"
                                    >
                                        {{ locVal(exp.description) }}
                                    </p>

                                    <div
                                        v-if="exp.location"
                                        class="mt-3 flex items-center gap-1.5 text-xs text-muted"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        {{ exp.location }}
                                    </div>
                                </div>
                            </div>

                            <!-- Empty column for even items on right (DESKTOP) -->
                            <div
                                v-if="index % 2 === 0"
                                class="hidden sm:block"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <p v-else class="mt-8 text-center text-ink-light dark:text-white/70">
                {{ t('about.no_experience', 'Aucune expérience renseignée pour le moment.') }}
            </p>
        </section>

        <!-- ==================== EDUCATION ==================== -->
        <section
            id="education-section"
            class="max-w-6xl mx-auto px-4 sm:px-6 pb-16 sm:pb-20 lg:pb-24"
        >
            <SectionHeading
                :title="t('about.education_title', 'Formation')"
                align="center"
            />
            <p
                v-if="sortedEducation.length"
                class="mt-2 text-center text-sm text-ink-light dark:text-white/50"
            >
                {{ sortedEducation.length }} diplôme{{ sortedEducation.length > 1 ? 's' : '' }}
            </p>

            <div v-if="sortedEducation.length" class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div
                    v-for="(edu, index) in sortedEducation"
                    :key="`edu-${index}`"
                    class="group relative rounded-2xl border border-border dark:border-border-dark bg-white/50 dark:bg-ink-light/15 p-6 hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 hover:-translate-y-1 transition-all duration-500"
                    :class="visibleSections.edu ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    :style="{ transitionDelay: `${index * 150}ms` }"
                >
                    <!-- Icon circle -->
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary/10 to-primary-light/10 border border-primary/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path d="M12 14l9-5-9-5-9 5 9 5z" opacity="0"/>
                        </svg>
                    </div>

                    <h3 class="text-base font-bold text-ink dark:text-white group-hover:text-primary transition-colors duration-300">
                        {{ locVal(edu.degree) }}
                    </h3>
                    <p class="mt-1 text-sm text-primary font-medium">
                        {{ locVal(edu.institution) }}
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2 text-xs font-mono text-muted">
                        <span
                            v-if="edu.duration"
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-primary/5 border border-primary/10"
                        >
                            {{ edu.duration }}
                        </span>
                        <span
                            v-if="edu.location"
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-ink/5 dark:bg-white/5 border border-border dark:border-border-dark"
                        >
                            {{ edu.location }}
                        </span>
                    </div>

                    <p
                        v-if="edu.description"
                        class="mt-3 text-xs text-ink-light dark:text-white/60 leading-relaxed"
                    >
                        {{ locVal(edu.description) }}
                    </p>

                    <!-- Index number decoration -->
                    <div
                        class="absolute top-3 right-3 text-4xl font-bold text-ink/5 dark:text-white/5 select-none leading-none"
                        aria-hidden="true"
                    >
                        {{ String(index + 1).padStart(2, '0') }}
                    </div>
                </div>
            </div>

            <p v-else class="mt-8 text-center text-ink-light dark:text-white/70">
                {{ t('about.no_education', 'Aucune formation renseignée pour le moment.') }}
            </p>
        </section>
    </AppLayout>
</template>

<style scoped>
@keyframes meshMove {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.95); }
}
</style>

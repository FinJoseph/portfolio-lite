<script setup>
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';

const { t } = useI18n();

const props = defineProps({
    testimonials: { type: Array, default: () => [] },
});

const ratingFilter = ref(0);

const filtered = computed(() => {
    if (!ratingFilter.value) return props.testimonials;
    return props.testimonials.filter(t => t.rating >= ratingFilter.value);
});

const averageRating = computed(() => {
    if (!props.testimonials.length) return 0;
    const sum = props.testimonials.reduce((acc, t) => acc + t.rating, 0);
    return (sum / props.testimonials.length).toFixed(1);
});

function ratingStars(rating) {
    return Array.from({ length: 5 }, (_, i) => i < rating);
}
</script>

<template>
    <Head :title="t('testimonials.meta.title', 'Témoignages')" :meta="[
        { name: 'description', content: t('testimonials.meta.description') },
        { property: 'og:title', content: t('testimonials.meta.title') },
        { property: 'og:description', content: t('testimonials.meta.description') },
    ]" />

    <AppLayout>
        <section class="max-w-6xl mx-auto px-6 py-16">
            <SectionHeading
                :eyebrow="t('testimonials.eyebrow', 'Recommandations')"
                :title="t('testimonials.title', 'Ils parlent de moi')"
                align="center"
            />
            <p class="mt-6 text-ink-light dark:text-white/70 max-w-2xl mx-auto text-center">
                {{ t('testimonials.subtitle', 'Ce que mes collaborateurs et clients disent de mon travail.') }}
            </p>

            <!-- Stats -->
            <div v-if="testimonials.length" class="mt-8 flex justify-center gap-8 text-center">
                <div>
                    <p class="text-3xl font-bold text-ink dark:text-white">{{ testimonials.length }}</p>
                    <p class="text-xs text-ink-light dark:text-white/60 mt-1">{{ t('testimonials.count', 'Témoignages') }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-primary">{{ averageRating }}</p>
                    <p class="text-xs text-ink-light dark:text-white/60 mt-1">{{ t('testimonials.average', 'Moyenne') }}</p>
                </div>
            </div>

            <!-- Rating Filter -->
            <div v-if="testimonials.length" class="mt-8 flex flex-wrap items-center justify-center gap-2">
                <span class="text-xs font-mono uppercase tracking-wider text-ink-light dark:text-white/50 mr-2">
                    {{ t('testimonials.filter', 'Filtrer') }}
                </span>
                <button
                    @click="ratingFilter = 0"
                    :class="[
                        'px-3 py-1.5 rounded-full text-xs font-medium transition-all',
                        ratingFilter === 0
                            ? 'bg-primary text-white'
                            : 'bg-white dark:bg-ink-light/30 text-ink-light dark:text-white/60 border border-border dark:border-border-dark hover:border-primary'
                    ]"
                >
                    {{ t('testimonials.all', 'Tous') }}
                </button>
                <button
                    v-for="star in [5, 4, 3]"
                    :key="star"
                    @click="ratingFilter = ratingFilter === star ? 0 : star"
                    :class="[
                        'px-3 py-1.5 rounded-full text-xs font-medium transition-all flex items-center gap-1',
                        ratingFilter === star
                            ? 'bg-amber-500 text-white'
                            : 'bg-white dark:bg-ink-light/30 text-ink-light dark:text-white/60 border border-border dark:border-border-dark hover:border-amber-500'
                    ]"
                >
                    {{ star }}
                    <svg class="w-3 h-3" :class="ratingFilter === star ? 'text-white' : 'text-amber-400'" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
            </div>

            <!-- Testimonials Grid -->
            <div v-if="filtered.length" class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <BaseCard
                    v-for="(testimonial, i) in filtered"
                    :key="i"
                    class="p-6 flex flex-col"
                >
                    <div class="flex items-start gap-4 mb-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div v-if="testimonial.photo" class="w-12 h-12 rounded-full overflow-hidden">
                                <img :src="testimonial.photo" :alt="testimonial.name" class="w-full h-full object-cover" loading="lazy" />
                            </div>
                            <div v-else class="w-12 h-12 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">
                                {{ testimonial.name.charAt(0).toUpperCase() }}
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-ink dark:text-white">{{ testimonial.name }}</h3>
                            <p v-if="testimonial.jobTitle || testimonial.company" class="text-xs text-ink-light dark:text-white/60 mt-0.5">
                                {{ [testimonial.jobTitle, testimonial.company].filter(Boolean).join(' — ') }}
                            </p>
                        </div>

                        <!-- Stars -->
                        <div class="flex gap-0.5 flex-shrink-0">
                            <svg
                                v-for="(filled, s) in ratingStars(testimonial.rating)"
                                :key="s"
                                class="w-4 h-4"
                                :class="filled ? 'text-amber-400' : 'text-border dark:text-border-dark'"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                aria-hidden="true"
                            >
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Quote -->
                    <div class="relative flex-1">
                        <svg class="absolute -top-1 -left-1 w-6 h-6 text-primary/10 dark:text-primary/20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151C7.563 6.068 6 8.789 6 11h4v10H0z" />
                        </svg>
                        <p class="text-sm text-ink-light dark:text-white/80 leading-relaxed pl-6 pt-1">
                            {{ testimonial.message }}
                        </p>
                    </div>

                    <div v-if="testimonial.submittedAt" class="mt-4 text-[10px] font-mono text-ink-light/50 dark:text-white/40">
                        {{ testimonial.submittedAt }}
                    </div>
                </BaseCard>
            </div>

            <!-- Empty State -->
            <div v-else class="mt-16 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-ink-light/30 dark:text-white/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="text-lg font-medium text-ink dark:text-white mb-2">
                    {{ t('testimonials.empty', 'Aucun témoignage pour le moment.') }}
                </h3>
                <p class="text-ink-light dark:text-white/60">
                    {{ ratingFilter ? t('testimonials.empty_filter', 'Essaie de modifier ton filtre.') : t('testimonials.coming_soon', 'Revenez bientôt !') }}
                </p>
                <button
                    v-if="ratingFilter"
                    @click="ratingFilter = 0"
                    class="mt-4 px-4 py-2 text-sm font-medium text-primary hover:underline"
                >
                    {{ t('testimonials.reset', 'Réinitialiser') }}
                </button>
            </div>
        </section>
    </AppLayout>
</template>

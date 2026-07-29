<script setup>
import { useI18n } from 'vue-i18n';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();

defineProps({
    testimonials: { type: Array, default: () => [] },
});

const mounted = ref(false);
onMounted(() => {
    requestAnimationFrame(() => {
        mounted.value = true;
    });
});

function cardClasses(index) {
    const base = 'transition-all duration-700 ease-out';
    const state = mounted.value
        ? 'opacity-100 translate-y-0'
        : 'opacity-0 translate-y-4';
    const delay = `delay-[${100 + index * 100}ms]`;
    return [base, state, delay];
}

function headerClasses() {
    const base = 'transition-all duration-700 ease-out';
    const state = mounted.value
        ? 'opacity-100 translate-y-0'
        : 'opacity-0 translate-y-4';
    return [base, state];
}

function authorRole(jobTitle, company) {
    if (jobTitle && company) {
        return `${jobTitle}, ${company}`;
    }
    return jobTitle || company || '';
}

function initials(name) {
    if (!name) return '?';
    const parts = name.trim().split(/\s+/);
    if (parts.length === 1) {
        return parts[0].charAt(0).toUpperCase();
    }
    return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
}
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div :class="headerClasses()">
            <SectionHeading
                :eyebrow="t('home.testimonials_preview.eyebrow')"
                :title="t('home.testimonials_preview.title')"
                align="center"
            />
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                v-for="(testimonial, index) in testimonials.slice(0, 3)"
                :key="testimonial.email"
                :class="cardClasses(index)"
                class="relative p-6 rounded-2xl border border-border dark:border-border-dark bg-white/50 dark:bg-ink-light/30 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:border-primary hover:shadow-lg hover:shadow-primary/10"
            >
                <!-- Decorative quote icon -->
                <span
                    aria-hidden="true"
                    class="absolute top-4 right-4 w-16 h-16 text-primary/10 select-none pointer-events-none flex items-center justify-center text-6xl leading-none"
                >
                    &ldquo;
                </span>

                <!-- Rating -->
                <div class="relative flex items-center gap-1 text-primary">
                    <span
                        v-for="n in 5"
                        :key="n"
                        :class="n <= testimonial.rating ? 'text-primary' : 'text-border dark:text-border-dark'"
                    >
                        &#9733;
                    </span>
                </div>

                <!-- Message -->
                <p class="mt-4 text-sm italic text-ink-light dark:text-white/70 line-clamp-4">
                    "{{ testimonial.message }}"
                </p>

                <!-- Author -->
                <div class="mt-6 flex items-center gap-3">
                    <img
                        v-if="testimonial.photo"
                        :src="testimonial.photo"
                        :alt="testimonial.name"
                        class="w-12 h-12 rounded-full object-cover"
                    />
                    <div
                        v-else
                        aria-hidden="true"
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-primary-dark text-white font-bold flex items-center justify-center text-sm"
                    >
                        {{ initials(testimonial.name) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-ink dark:text-white">
                            {{ testimonial.name }}
                        </p>
                        <p
                            v-if="testimonial.jobTitle || testimonial.company"
                            class="text-xs text-muted"
                        >
                            {{ authorRole(testimonial.jobTitle, testimonial.company) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <BaseButton :as="Link" href="/testimonials" variant="ghost">
                {{ t('home.testimonials_preview.cta') }} &rarr;
            </BaseButton>
        </div>
    </section>
</template>

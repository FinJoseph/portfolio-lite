<script setup>
import { useI18n } from 'vue-i18n';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();

defineProps({
    projects: { type: Array, default: () => [] },
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

function placeholderLetter(title) {
    return (title || '?').charAt(0).toUpperCase();
}
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div :class="headerClasses()">
            <SectionHeading
                :eyebrow="t('home.projects_preview.eyebrow')"
                :title="t('home.projects_preview.title')"
                align="center"
            />
        </div>

        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <Link
                v-for="(project, index) in projects.slice(0, 3)"
                :key="project.slug"
                :href="`/projects/${project.slug}`"
                :class="cardClasses(index)"
                class="group relative block h-80 rounded-2xl overflow-hidden border border-border dark:border-border-dark hover:border-primary hover:shadow-xl hover:shadow-primary/20 transition-all duration-300"
            >
                <!-- Background image or placeholder -->
                <img
                    v-if="project.coverImage"
                    :src="project.coverImage"
                    :alt="project.title"
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <div
                    v-else
                    class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary/20 to-primary-dark/20 flex items-center justify-center"
                >
                    <span class="text-6xl font-bold text-primary/50">
                        {{ placeholderLetter(project.title) }}
                    </span>
                </div>

                <!-- Permanent dark gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/50 to-transparent"></div>

                <!-- Green hover overlay -->
                <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <!-- Content -->
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-center group-hover:justify-center transition-all duration-500">
                    <div>
                        <h3 class="text-xl font-bold text-white">
                            {{ project.title }}
                        </h3>
                        <p
                            v-if="project.excerpt"
                            class="mt-2 text-sm text-white/80 line-clamp-2"
                        >
                            {{ project.excerpt }}
                        </p>
                        <div
                            v-if="project.technologies && project.technologies.length"
                            class="mt-3 flex flex-wrap justify-center gap-2"
                        >
                            <span
                                v-for="tech in project.technologies.slice(0, 3)"
                                :key="tech"
                                class="bg-white/10 backdrop-blur text-white text-xs px-2 py-1 rounded-full"
                            >
                                {{ tech }}
                            </span>
                        </div>
                        <span
                            class="mt-4 inline-block opacity-0 group-hover:opacity-100 transition-opacity duration-500 text-white text-sm font-semibold"
                        >
                            Voir le projet →
                        </span>
                    </div>
                </div>
            </Link>
        </div>

        <div class="mt-10 text-center">
            <BaseButton :as="Link" href="/projects" variant="ghost">
                {{ t('home.projects_preview.cta') }} →
            </BaseButton>
        </div>
    </section>
</template>

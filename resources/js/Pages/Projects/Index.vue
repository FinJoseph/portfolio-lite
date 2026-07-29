<script setup>
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();

const props = defineProps({
    projects: { type: Array, required: true },
    categories: { type: Array, required: true },
    technologies: { type: Array, required: true },
});

const activeCategory = ref('all');
const activeTech = ref('all');
const searchQuery = ref('');

const filteredProjects = computed(() => {
    let result = props.projects;

    if (activeCategory.value !== 'all') {
        result = result.filter(p => p.category === activeCategory.value);
    }

    if (activeTech.value !== 'all') {
        result = result.filter(p => p.technologies.includes(activeTech.value));
    }

    if (searchQuery.value.trim()) {
        const q = searchQuery.value.trim().toLowerCase();
        result = result.filter(p =>
            p.title.toLowerCase().includes(q) ||
            p.excerpt.toLowerCase().includes(q) ||
            p.technologies.some(t => t.toLowerCase().includes(q))
        );
    }

    return result;
});

const statusConfig = {
    completed: { class: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' },
    'in-progress': { class: 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' },
    draft: { class: 'bg-gray-100 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400' },
};

function statusLabel(status) {
    return t(`projects.status.${status}`, status);
}
</script>

<template>
    <Head :title="t('projects.meta.title', 'Projets')" :meta="[
        { name: 'description', content: t('projects.meta.description') },
        { property: 'og:title', content: t('projects.meta.title') },
        { property: 'og:description', content: t('projects.meta.description') },
    ]" />

    <AppLayout>
        <section class="max-w-6xl mx-auto px-6 py-16">
            <SectionHeading
                :eyebrow="t('projects.eyebrow', 'Portfolio')"
                :title="t('projects.title', 'Mes projets')"
                align="center"
            />
            <p class="mt-6 text-ink-light dark:text-white/70 max-w-2xl mx-auto text-center">
                {{ t('projects.subtitle', 'Une sélection de projets web, applications et expérimentations.') }}
            </p>

            <!-- Filters -->
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center">
                <div class="relative w-full sm:w-64">
                    <input
                        type="search"
                        v-model="searchQuery"
                        :placeholder="t('projects.search_placeholder', 'Rechercher un projet...')"
                        class="w-full px-4 py-2.5 pl-10 rounded-xl border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 text-ink dark:text-white placeholder:text-ink-light/50 dark:placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                    />
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-ink-light/50 dark:text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-2 justify-center">
                <button
                    v-for="cat in ['all', ...categories]"
                    :key="cat"
                    @click="activeCategory = cat"
                    :class="[
                        'px-4 py-2 rounded-full text-sm font-medium transition-all',
                        activeCategory === cat
                            ? 'bg-primary text-white shadow-md shadow-primary/30'
                            : 'bg-white dark:bg-ink-light/30 text-ink dark:text-white border border-border dark:border-border-dark hover:border-primary/50'
                    ]"
                >
                    {{ cat === 'all' ? t('projects.categories.all', 'Tous') : t('projects.categories.' + cat, cat) }}
                </button>
            </div>

            <div class="mt-4 flex flex-wrap gap-2 justify-center">
                <button
                    v-for="tech in ['all', ...technologies]"
                    :key="tech"
                    @click="activeTech = tech"
                    :class="[
                        'px-3 py-1 rounded-full text-xs font-mono transition-all',
                        activeTech === tech
                            ? 'bg-ink dark:bg-white text-white dark:text-ink'
                            : 'bg-white dark:bg-ink-light/30 text-ink-light dark:text-white/60 border border-border dark:border-border-dark hover:text-ink dark:hover:text-white'
                    ]"
                >
                    {{ tech === 'all' ? t('projects.technologies.all', 'Toutes') : tech }}
                </button>
            </div>

            <!-- Projects Grid -->
            <div v-if="filteredProjects.length" class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Link
                    v-for="project in filteredProjects"
                    :key="project.slug"
                    :href="'/projects/' + project.slug"
                    class="group block"
                >
                    <BaseCard class="h-full flex flex-col overflow-hidden group-hover:shadow-lg group-hover:border-primary/50 transition-all duration-300">
                        <div v-if="project.coverImage" class="aspect-video bg-ink-light/10 dark:bg-white/5 overflow-hidden">
                            <img
                                :src="project.coverImage"
                                :alt="project.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                        </div>
                        <div v-else class="aspect-video bg-gradient-to-br from-primary/10 to-primary-light/10 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    v-if="project.status"
                                    :class="['px-2 py-0.5 rounded-full text-[10px] font-medium uppercase tracking-wider', (statusConfig[project.status]?.class || statusConfig.draft.class)]"
                                >
                                    {{ statusLabel(project.status) }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-primary/10 dark:bg-primary/20 text-primary">
                                    {{ t('projects.categories.' + project.category, project.category) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-ink dark:text-white group-hover:text-primary transition-colors">
                                {{ project.title }}
                            </h3>

                            <p class="mt-2 text-sm text-ink-light dark:text-white/70 line-clamp-2 flex-1">
                                {{ project.excerpt }}
                            </p>

                            <div v-if="project.technologies.length" class="mt-4 flex flex-wrap gap-1.5">
                                <span
                                    v-for="tech in project.technologies.slice(0, 4)"
                                    :key="tech"
                                    class="px-2 py-0.5 text-[10px] font-mono rounded bg-ink-light/5 dark:bg-white/5 text-ink-light dark:text-white/60"
                                >
                                    {{ tech }}
                                </span>
                                <span
                                    v-if="project.technologies.length > 4"
                                    class="px-2 py-0.5 text-[10px] font-mono text-ink-light/50 dark:text-white/40"
                                >
                                    +{{ project.technologies.length - 4 }}
                                </span>
                            </div>
                        </div>
                    </BaseCard>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-else class="mt-16 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-ink-light/30 dark:text-white/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-medium text-ink dark:text-white mb-2">
                    {{ t('projects.no_projects', 'Aucun projet trouvé') }}
                </h3>
                <p class="text-ink-light dark:text-white/60">
                    {{ searchQuery || activeCategory !== 'all' || activeTech !== 'all'
                        ? t('projects.empty_filters', 'Essaie de modifier tes filtres.')
                        : t('projects.coming_soon', 'Cette page est en cours de construction.') }}
                </p>
                <button
                    v-if="searchQuery || activeCategory !== 'all' || activeTech !== 'all'"
                    @click="searchQuery = ''; activeCategory = 'all'; activeTech = 'all'"
                    class="mt-4 px-4 py-2 text-sm font-medium text-primary hover:underline"
                >
                    {{ t('projects.reset_filters', 'Réinitialiser les filtres') }}
                </button>
            </div>
        </section>
    </AppLayout>
</template>

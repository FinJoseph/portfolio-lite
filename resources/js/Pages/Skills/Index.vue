<script setup>
import { computed, ref, watch, toRefs } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import SkillIcon from '@/Components/UI/SkillIcon.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';

const { t } = useI18n();

const props = defineProps({
    skillsByCategory: {
        type: Object,
        required: true,
    },
    skills: {
        type: Array,
        required: true,
    },
});

const { skillsByCategory, skills } = toRefs(props);

const activeCategory = ref('all');
const searchQuery = ref('');

const categories = computed(() => {
    const cats = Object.keys(skillsByCategory.value);
    return ['all', ...cats];
});

const categoryLabel = (key) => {
    if (key === 'all') return t('skills.categories.all', 'Toutes');
    return t(`skills.categories.${key}`, key);
};

const filteredSkills = computed(() => {
    let result = skills.value;

    if (activeCategory.value !== 'all') {
        result = result.filter(s => s.category === activeCategory.value);
    }

    if (searchQuery.value.trim()) {
        const q = searchQuery.value.trim().toLowerCase();
        result = result.filter(s =>
            s.name.toLowerCase().includes(q) ||
            s.category.toLowerCase().includes(q) ||
            s.description.toLowerCase().includes(q)
        );
    }

    return result;
});

const groupedFilteredSkills = computed(() => {
    const grouped = {};
    for (const skill of filteredSkills.value) {
        if (!grouped[skill.category]) grouped[skill.category] = [];
        grouped[skill.category].push(skill);
    }
    return grouped;
});

const levelLabel = (level) => {
    if (level >= 90) return t('skills.level.expert', 'Expert');
    if (level >= 70) return t('skills.level.advanced', 'Avancé');
    if (level >= 40) return t('skills.level.intermediate', 'Intermédiaire');
    return t('skills.level.beginner', 'Débutant');
};

const levelColor = (level) => {
    if (level >= 90) return 'text-amber-500';
    if (level >= 70) return 'text-green-500';
    if (level >= 40) return 'text-blue-500';
    return 'text-gray-500';
};

const barColor = (level) => {
    if (level >= 90) return '#f59e0b';
    if (level >= 70) return '#22c55e';
    if (level >= 40) return '#3b82f6';
    return '#6b7280';
};

watch(() => activeCategory.value, () => {
    searchQuery.value = '';
});
</script>

<template>
    <Head :title="t('skills.meta.title')" :meta="[
        { name: 'description', content: t('skills.meta.description') },
        { property: 'og:title', content: t('skills.meta.title') },
        { property: 'og:description', content: t('skills.meta.description') },
    ]" />

    <AppLayout>
        <section class="max-w-6xl mx-auto px-6 py-16">
            <SectionHeading
                :eyebrow="t('skills.eyebrow')"
                :title="t('skills.title')"
                align="center"
            />
            <p class="mt-6 text-ink-light dark:text-white/70 max-w-2xl mx-auto text-center">
                {{ t('skills.subtitle') }}
            </p>

            <!-- Search & Filter Bar -->
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center">
                <div class="relative w-full sm:w-64">
                    <input
                        type="search"
                        v-model="searchQuery"
                        :placeholder="t('blog.search.placeholder')"
                        class="w-full px-4 py-2.5 pl-10 rounded-xl border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 text-ink dark:text-white placeholder:text-ink-light/50 dark:placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        aria-label="Rechercher une compétence"
                    />
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-ink-light/50 dark:text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <div class="flex flex-wrap gap-2 justify-center" role="tablist" aria-label="Filtrer par catégorie">
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        @click="activeCategory = cat"
                        :class="[
                            'px-4 py-2 rounded-full text-sm font-medium transition-all',
                            activeCategory === cat
                                ? 'bg-primary text-white shadow-md shadow-primary/30'
                                : 'bg-white dark:bg-ink-light/30 text-ink dark:text-white border border-border dark:border-border-dark hover:border-primary/50'
                        ]"
                        :aria-selected="activeCategory === cat"
                        role="tab"
                    >
                        {{ categoryLabel(cat) }}
                    </button>
                </div>
            </div>

            <!-- Skills Grid -->
            <div class="mt-10" v-if="Object.keys(groupedFilteredSkills).length > 0">
                <div v-for="(skills, category) in groupedFilteredSkills" :key="category">
                    <h3 class="text-lg sm:text-xl font-semibold text-ink dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary" aria-hidden="true"></span>
                        {{ categoryLabel(category) }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
                        <BaseCard
                            v-for="skill in skills"
                            :key="skill.name"
                            class="p-6 flex flex-col h-full group cursor-pointer"
                            @click="router.get('/skills/' + skill.slug)"
                        >
                            <div class="flex items-start gap-4 mb-4">
                                <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                    <SkillIcon :name="skill.icon" size="w-7 h-7" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-ink dark:text-white truncate">{{ skill.name }}</h4>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span :class="['px-2 py-0.5 rounded-full text-xs font-medium', levelColor(skill.level)]">
                                            {{ levelLabel(skill.level) }}
                                        </span>
                                        <div class="flex-1 h-1.5 bg-border dark:bg-border-dark rounded-full overflow-hidden">
                                            <div
                                                class="h-full rounded-full transition-all duration-1000 ease-out"
                                                :style="{ width: skill.level + '%', backgroundColor: barColor(skill.level) }"
                                                role="progressbar"
                                                :aria-valuenow="skill.level"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                :aria-label="t('skills.level.label') + ': ' + skill.level + '%'"
                                            ></div>
                                        </div>
                                        <span class="text-xs text-ink-light dark:text-white/50 font-mono">{{ skill.level }}%</span>
                                    </div>
                                </div>
                            </div>

                            <p v-if="skill.description" class="text-sm text-ink-light dark:text-white/70 mb-4 flex-1">
                                {{ skill.description }}
                            </p>

                            <div v-if="skill.relatedSkills && skill.relatedSkills.length > 0" class="pt-4 border-t border-border dark:border-border-dark">
                                <p class="text-xs font-medium text-ink-light dark:text-white/50 mb-2 uppercase tracking-wide">
                                    {{ t('skills.related_skills') }}
                                </p>
                                <div class="flex flex-wrap gap-1.5">
                                    <span
                                        v-for="related in skill.relatedSkills"
                                        :key="related"
                                        class="px-2 py-0.5 text-xs rounded bg-primary/10 dark:bg-primary/20 text-primary dark:text-primary-dark"
                                    >
                                        {{ related }}
                                    </span>
                                </div>
                            </div>
                        </BaseCard>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="mt-16 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-ink-light/30 dark:text-white/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-medium text-ink dark:text-white mb-2">
                    {{ t('skills.no_skills') }}
                </h3>
                <p class="text-ink-light dark:text-white/60">
                    {{ searchQuery
                        ? t('blog.empty.message')
                        : t('skills.coming_soon') }}
                </p>
                <button
                    v-if="searchQuery || activeCategory !== 'all'"
                    @click="searchQuery = ''; activeCategory = 'all'"
                    class="mt-4 px-4 py-2 text-sm font-medium text-primary hover:underline"
                >
                    {{ t('blog.filters.reset') }}
                </button>
            </div>
        </section>
    </AppLayout>
</template>
<script setup>
import { onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import SkillIcon from '@/Components/UI/SkillIcon.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';

const { t } = useI18n();

defineProps({
    skill: {
        type: Object,
        required: true,
    },
    relatedSkills: {
        type: Array,
        default: () => [],
    },
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

const categoryLabel = (key) => {
    return t(`skills.categories.${key}`, key);
};

onMounted(() => {
    document.title = `${skill.name} — ${t('skills.meta.title')}`;
});
</script>

<template>
    <Head :title="`${skill.name} — ${t('skills.meta.title')}`" :meta="[
        { name: 'description', content: skill.description || t('skills.meta.description') },
        { property: 'og:title', content: `${skill.name} — ${t('skills.meta.title')}` },
        { property: 'og:description', content: skill.description || t('skills.meta.description') },
    ]" />

    <AppLayout>
        <section class="max-w-4xl mx-auto px-6 py-16">
            <!-- Back Link -->
            <div class="mb-8">
                <Link
                    href="/skills"
                    class="inline-flex items-center gap-2 text-sm text-ink-light dark:text-white/60 hover:text-primary dark:hover:text-primary-light transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ t('blog.show.back') }}
                </Link>
            </div>

            <!-- Skill Header -->
            <div class="mb-10">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-6">
                    <div class="flex-shrink-0 w-20 h-20 rounded-2xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary">
                        <SkillIcon :name="skill.icon" size="w-10 h-10" />
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-primary/10 dark:bg-primary/20 text-primary dark:text-primary-light mb-3">
                            {{ categoryLabel(skill.category) }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-bold text-ink dark:text-white">{{ skill.name }}</h1>
                        <div class="mt-4 flex items-center gap-4">
                            <div class="flex-1 sm:w-48">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-medium text-ink dark:text-white">{{ t('skills.level.label') }}</span>
                                    <span :class="['text-sm font-mono', levelColor(skill.level)]">{{ skill.level }}%</span>
                                </div>
                                <div class="h-2.5 bg-border dark:bg-border-dark rounded-full overflow-hidden">
                                    <div
                                        :class="levelColor(skill.level).replace('text', 'bg')"
                                        class="h-full rounded-full transition-all duration-1000 ease-out"
                                        :style="{ width: skill.level + '%' }"
                                        role="progressbar"
                                        :aria-valuenow="skill.level"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    ></div>
                                </div>
                            </div>
                            <span :class="['px-3 py-1 rounded-full text-sm font-medium', levelColor(skill.level).replace('text', 'bg') + ' text-white']">
                                {{ levelLabel(skill.level) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div v-if="skill.description" class="prose prose-ink dark:prose-invert max-w-none text-lg text-ink-light dark:text-white/80">
                    {{ skill.description }}
                </div>
            </div>

            <!-- Related Skills -->
            <div v-if="relatedSkills.length > 0" class="mt-12">
                <SectionHeading
                    :title="t('skills.related_skills')"
                    :eyebrow="t('skills.eyebrow')"
                />
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <BaseCard
                        v-for="related in relatedSkills"
                        :key="related.name"
                        class="p-5 flex items-center gap-4 group hover:shadow-md transition-shadow cursor-pointer"
                        @click="router.get('/skills/' + related.slug)"
                    >
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <SkillIcon :name="related.icon" size="w-6 h-6" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-ink dark:text-white truncate">{{ related.name }}</h4>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="text-xs font-mono" :class="levelColor(related.level)">{{ related.level }}%</span>
                                <div class="flex-1 h-1 bg-border dark:bg-border-dark rounded-full overflow-hidden">
                                    <div
                                        :class="levelColor(related.level).replace('text', 'bg')"
                                        class="h-full rounded-full"
                                        :style="{ width: related.level + '%' }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-ink-light/30 dark:text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </BaseCard>
                </div>
            </div>

            <!-- No Related Skills -->
            <div v-else class="mt-12 text-center py-8">
                <p class="text-ink-light dark:text-white/60">
                    {{ t('skills.no_skills') }}
                </p>
            </div>
        </section>
    </AppLayout>
</template>
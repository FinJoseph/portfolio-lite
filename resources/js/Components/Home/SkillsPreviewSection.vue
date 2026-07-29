<script setup>
import { useI18n } from 'vue-i18n';
import { computed, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import SkillIcon from '@/Components/UI/SkillIcon.vue';

const { t } = useI18n();

const props = defineProps({
    skills: { type: Array, default: () => [] },
});

const featuredSkill = computed(() => {
    if (!props.skills || props.skills.length === 0) return null;
    let featured = props.skills[0];
    for (let i = 1; i < props.skills.length; i++) {
        if ((props.skills[i].level ?? 0) > (featured.level ?? 0)) {
            featured = props.skills[i];
        }
    }
    return featured;
});

const otherSkills = computed(() => {
    if (!props.skills || props.skills.length === 0) return [];
    const featuredName = featuredSkill.value?.name;
    return props.skills
        .filter((s) => s.name !== featuredName)
        .slice()
        .sort((a, b) => (a.order ?? 0) - (b.order ?? 0))
        .slice(0, 5);
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

function otherCardClasses(index) {
    const base = 'transition-all duration-700 ease-out';
    const state = mounted.value
        ? 'opacity-100 translate-y-0'
        : 'opacity-0 translate-y-4';
    const delay = `delay-[${200 + index * 100}ms]`;
    return [base, state, delay];
}
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div
            class="transition-all duration-700 ease-out"
            :class="[mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4']"
        >
            <SectionHeading
                :eyebrow="t('home.skills_preview.eyebrow')"
                :title="t('home.skills_preview.title')"
                align="center"
            />
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Featured skill card -->
            <div
                v-if="featuredSkill"
                :class="cardClasses(0)"
                class="md:col-span-2 md:row-span-2 rounded-2xl border border-border dark:border-border-dark bg-gradient-to-br from-primary/10 to-transparent p-6 md:p-8 hover:scale-[1.02] hover:border-primary hover:shadow-lg hover:shadow-primary/10 transition-all duration-300"
            >
                <div class="flex items-start gap-4">
                    <div class="relative shrink-0">
                        <span
                            class="absolute inset-0 rounded-full bg-primary/30 blur-md animate-pulse"
                            aria-hidden="true"
                        ></span>
                        <div
                            class="relative w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white/70 dark:bg-ink-light/40 flex items-center justify-center text-primary border border-border dark:border-border-dark"
                        >
                            <SkillIcon :name="featuredSkill.icon || featuredSkill.name" size="w-8 h-8 md:w-10 md:h-10" />
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xl md:text-2xl font-bold text-ink dark:text-white">
                            {{ featuredSkill.name }}
                        </h3>
                        <span
                            v-if="featuredSkill.category"
                            class="inline-block mt-1.5 px-2.5 py-0.5 text-[11px] font-mono uppercase tracking-wider rounded-full bg-primary/10 dark:bg-primary/15 text-primary"
                        >
                            {{ featuredSkill.category }}
                        </span>
                    </div>
                </div>

                <p
                    v-if="featuredSkill.description"
                    class="mt-5 text-sm md:text-base text-ink-light dark:text-white/70 leading-relaxed"
                >
                    {{ featuredSkill.description }}
                </p>

                <div
                    v-if="featuredSkill.relatedSkills && featuredSkill.relatedSkills.length"
                    class="mt-4 flex flex-wrap gap-2"
                >
                    <span
                        v-for="rel in featuredSkill.relatedSkills.slice(0, 4)"
                        :key="rel"
                        class="font-mono text-[11px] px-2 py-0.5 rounded-full bg-paper dark:bg-ink-light/50 text-ink-light dark:text-white/70 border border-border dark:border-border-dark"
                    >
                        {{ rel }}
                    </span>
                </div>

                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono text-xs uppercase tracking-wider text-muted">
                            {{ t('home.skills_preview.level', 'Proficiency') }}
                        </span>
                        <span class="font-mono text-xs font-semibold text-primary">
                            {{ featuredSkill.level }}%
                        </span>
                    </div>
                    <div class="h-2 rounded-full bg-border dark:bg-border-dark overflow-hidden">
                        <div
                            class="h-full rounded-full bg-primary transition-all duration-1000 ease-out"
                            :style="{ width: mounted ? `${featuredSkill.level}%` : '0%' }"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Other skill cards -->
            <div
                v-for="(skill, index) in otherSkills"
                :key="skill.name"
                :class="otherCardClasses(index)"
                class="rounded-2xl border border-border dark:border-border-dark bg-white/50 dark:bg-ink-light/30 p-5 hover:scale-[1.02] hover:border-primary hover:shadow-lg hover:shadow-primary/10 transition-all duration-300"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="shrink-0 w-10 h-10 rounded-xl bg-white/70 dark:bg-ink-light/40 flex items-center justify-center text-primary border border-border dark:border-border-dark"
                    >
                        <SkillIcon :name="skill.icon || skill.name" size="w-5 h-5" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-sm text-ink dark:text-white truncate">
                            {{ skill.name }}
                        </p>
                        <span
                            v-if="skill.category"
                            class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-mono uppercase tracking-wider rounded-full bg-primary/10 dark:bg-primary/15 text-primary"
                        >
                            {{ skill.category }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="font-mono text-[10px] uppercase tracking-wider text-muted">
                            {{ t('home.skills_preview.level', 'Proficiency') }}
                        </span>
                        <span class="font-mono text-[11px] font-semibold text-primary">
                            {{ skill.level }}%
                        </span>
                    </div>
                    <div class="h-1.5 rounded-full bg-border dark:bg-border-dark overflow-hidden">
                        <div
                            class="h-full rounded-full bg-primary transition-all duration-1000 ease-out"
                            :style="{ width: mounted ? `${skill.level}%` : '0%' }"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <BaseButton :as="Link" href="/skills" variant="ghost">
                {{ t('home.skills_preview.cta') }} →
            </BaseButton>
        </div>
    </section>
</template>

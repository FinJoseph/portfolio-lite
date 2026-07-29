<script setup>
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();

defineProps({
    bio: { type: String, default: '' },
    jobTitle: { type: String, default: '' },
    avatar: { type: String, default: null },
});
</script>

<template>
    <section class="max-w-6xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-[auto_1fr] gap-10 items-center">
            <img
                v-if="avatar"
                :src="avatar"
                :alt="jobTitle"
                class="w-32 h-32 rounded-full object-cover border border-slate-200 dark:border-slate-700"
            />

            <div>
                <SectionHeading
                    :eyebrow="t('home.about_preview.eyebrow')"
                    :title="t('home.about_preview.title')"
                />
                <p class="mt-4 text-slate-600 dark:text-slate-300 max-w-2xl">
                    {{ bio }}
                </p>
                <div class="mt-6">
                    <BaseButton :as="Link" href="/about" variant="ghost">
                        {{ t('home.about_preview.cta') }} →
                    </BaseButton>
                </div>
            </div>
        </div>
    </section>
</template>
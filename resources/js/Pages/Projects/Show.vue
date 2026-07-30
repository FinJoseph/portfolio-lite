<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();

const props = defineProps({
    project: { type: Object, required: true },
    relatedProjects: { type: Array, default: () => [] },
});

const selectedImage = ref(null);

function openLightbox(img) {
    selectedImage.value = img;
}

function closeLightbox() {
    selectedImage.value = null;
}

function onKeydown(e) {
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'ArrowRight') nextImage();
}

onMounted(() => window.addEventListener('keydown', onKeydown));
onUnmounted(() => window.removeEventListener('keydown', onKeydown));

function prevImage() {
    const gallery = props.project.gallery;
    if (!gallery?.length) return;
    const idx = gallery.indexOf(selectedImage.value);
    if (idx > 0) selectedImage.value = gallery[idx - 1];
}

function nextImage() {
    const gallery = props.project.gallery;
    if (!gallery?.length) return;
    const idx = gallery.indexOf(selectedImage.value);
    if (idx < gallery.length - 1) selectedImage.value = gallery[idx + 1];
}

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
    <Head :title="project.metaTitle" :meta="[
        { name: 'description', content: project.metaDescription },
        { property: 'og:title', content: project.metaTitle },
        { property: 'og:description', content: project.metaDescription },
        { property: 'og:image', content: project.coverImage || '' },
    ]" />

    <AppLayout>
        <section class="max-w-4xl mx-auto px-6 py-16">
            <!-- Back Link -->
            <div class="mb-8">
                <Link
                    href="/projects"
                    class="inline-flex items-center gap-2 text-sm text-ink-light dark:text-white/60 hover:text-primary dark:hover:text-primary-light transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ t('projects.back', 'Retour aux projets') }}
                </Link>
            </div>

            <!-- Cover Image -->
            <div
                v-if="project.coverImage"
                class="aspect-video rounded-2xl overflow-hidden bg-ink-light/10 dark:bg-white/5 mb-10 cursor-pointer"
                @click="openLightbox(project.coverImage)"
            >
                <img
                    :src="project.coverImage"
                    :alt="project.title"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                />
            </div>

            <!-- Project Header -->
            <div class="mb-8">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span
                        v-if="project.status"
                        :class="['px-3 py-1 rounded-full text-xs font-medium uppercase tracking-wider', (statusConfig[project.status]?.class || statusConfig.draft.class)]"
                    >
                        {{ statusLabel(project.status) }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-primary/10 dark:bg-primary/20 text-primary">
                        {{ t('projects.categories.' + project.category, project.category) }}
                    </span>
                    <span v-if="project.completedAt" class="text-xs text-ink-light dark:text-white/50 font-mono">
                        {{ project.completedAt }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold text-ink dark:text-white">
                    {{ project.title }}
                </h1>

                <p class="mt-4 text-lg text-ink-light dark:text-white/70">
                    {{ project.excerpt }}
                </p>

                <!-- Technologies -->
                <div v-if="project.technologies.length" class="mt-6 flex flex-wrap gap-2">
                    <span
                        v-for="tech in project.technologies"
                        :key="tech"
                        class="px-3 py-1.5 text-xs font-mono rounded-lg bg-ink-light/5 dark:bg-white/5 border border-border dark:border-border-dark text-ink-light dark:text-white/70"
                    >
                        {{ tech }}
                    </span>
                </div>

                <!-- Links -->
                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        v-if="project.siteUrl"
                        :href="project.siteUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-medium hover:bg-primary-dark transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        {{ t('projects.visit_site', 'Voir le site') }}
                    </a>
                    <a
                        v-if="project.githubUrl"
                        :href="project.githubUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-border dark:border-border-dark text-ink dark:text-white text-sm font-medium hover:border-primary hover:text-primary transition-colors"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        {{ t('projects.view_code', 'Voir le code') }}
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div v-if="project.content" class="prose prose-ink dark:prose-invert max-w-none">
                <div v-html="project.content"></div>
            </div>

            <!-- Gallery -->
            <div v-if="project.gallery && project.gallery.length" class="mt-12">
                <SectionHeading
                    :title="t('projects.gallery', 'Galerie')"
                    :eyebrow="t('projects.eyebrow', 'Portfolio')"
                />
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div
                        v-for="(img, i) in project.gallery"
                        :key="i"
                        class="rounded-xl overflow-hidden bg-ink-light/5 dark:bg-white/5 cursor-pointer"
                        @click="openLightbox(img)"
                    >
                        <img
                            :src="img"
                            :alt="`${project.title} - image ${i + 1}`"
                            class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        />
                    </div>
                </div>
            </div>

            <!-- Lightbox -->
            <Teleport to="body">
                <div
                    v-if="selectedImage"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
                    @click.self="closeLightbox"
                >
                    <button
                        class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/25 transition-colors"
                        @click="closeLightbox"
                        aria-label="Fermer"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <button
                        v-if="project.gallery.length > 1"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/25 transition-colors"
                        @click="prevImage"
                        aria-label="Précédente"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <img
                        :src="selectedImage"
                        class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
                        @click.stop
                    />

                    <button
                        v-if="project.gallery.length > 1"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/25 transition-colors"
                        @click="nextImage"
                        aria-label="Suivante"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/70 text-sm font-mono"
                    >
                        {{ project.gallery.indexOf(selectedImage) + 1 }} / {{ project.gallery.length }}
                    </div>
                </div>
            </Teleport>

            <!-- Related Projects -->
            <div v-if="relatedProjects.length" class="mt-16">
                <SectionHeading
                    :title="t('projects.related', 'Projets similaires')"
                    :eyebrow="t('projects.eyebrow', 'Portfolio')"
                />
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <Link
                        v-for="related in relatedProjects"
                        :key="related.slug"
                        :href="'/projects/' + related.slug"
                        class="group"
                    >
                        <BaseCard class="p-5 h-full group-hover:shadow-md group-hover:border-primary/50 transition-all">
                            <div v-if="related.coverImage" class="aspect-video rounded-lg overflow-hidden mb-3 bg-ink-light/5">
                                <img
                                    :src="related.coverImage"
                                    :alt="related.title"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                />
                            </div>
                            <h4 class="font-semibold text-ink dark:text-white group-hover:text-primary transition-colors">
                                {{ related.title }}
                            </h4>
                            <p class="mt-1 text-xs text-ink-light dark:text-white/60 line-clamp-2">
                                {{ related.excerpt }}
                            </p>
                            <div class="mt-2 flex flex-wrap gap-1">
                                <span
                                    v-for="tech in related.technologies.slice(0, 3)"
                                    :key="tech"
                                    class="px-1.5 py-0.5 text-[10px] font-mono bg-ink-light/5 dark:bg-white/5 rounded text-ink-light dark:text-white/50"
                                >
                                    {{ tech }}
                                </span>
                            </div>
                        </BaseCard>
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

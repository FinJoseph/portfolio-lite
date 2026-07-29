<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import JsonLd from '@/Components/UI/JsonLd.vue';

const { t, locale } = useI18n();

const props = defineProps({
    articles: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    tags: { type: Array, default: () => [] },
});

const settings = computed(() => usePage().props.settings ?? {});
const siteName = computed(() => settings.value.site_name || 'Portfolio');

const search = ref('');
const activeCategory = ref(null);
const activeTag = ref(null);
const currentPage = ref(1);
const perPage = 6;

const seoTitle = computed(() => t('blog.meta.title', 'Blog'));
const seoDescription = computed(() => t('blog.meta.description', ''));
const currentUrl = computed(() => {
    const u = usePage().props?.url;
    if (typeof u === 'string' && u.length > 0) return u;
    if (typeof window !== 'undefined') return window.location.href;
    return '';
});

const filtered = computed(() => {
    const q = search.value.trim().toLowerCase();
    return props.articles.filter((article) => {
        if (activeCategory.value && article.category !== activeCategory.value) {
            return false;
        }
        if (activeTag.value && !(article.tags || []).includes(activeTag.value)) {
            return false;
        }
        if (q) {
            const haystack = [
                article.title,
                article.excerpt,
                (article.tags || []).join(' '),
            ].join(' ').toLowerCase();
            if (!haystack.includes(q)) return false;
        }
        return true;
    });
});

const totalPages = computed(() => Math.max(1, Math.ceil(filtered.value.length / perPage)));

const paged = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    return filtered.value.slice(start, start + perPage);
});

watch([search, activeCategory, activeTag], () => {
    currentPage.value = 1;
});

function resetFilters() {
    search.value = '';
    activeCategory.value = null;
    activeTag.value = null;
    currentPage.value = 1;
}

function formatDate(date) {
    if (!date) return '';
    try {
        return new Intl.DateTimeFormat(locale.value, {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        }).format(new Date(date));
    } catch (e) {
        return date;
    }
}

function readingLabel(min) {
    return t('blog.reading_time', 'min de lecture').replace('{n}', String(min || 1));
}

const jsonLd = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'Blog',
    name: seoTitle.value,
    description: seoDescription.value,
    url: currentUrl.value,
    inLanguage: locale.value,
    publisher: {
        '@type': 'Person',
        name: siteName.value,
    },
}));
</script>

<template>
    <Head>
        <title>{{ seoTitle }}</title>
        <meta name="description" :content="seoDescription" />
        <link rel="canonical" :href="currentUrl" />
        <meta property="og:type" content="website" />
        <meta property="og:title" :content="seoTitle" />
        <meta property="og:description" :content="seoDescription" />
        <meta property="og:url" :content="currentUrl" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="seoTitle" />
        <meta name="twitter:description" :content="seoDescription" />
        <link
            rel="alternate"
            type="application/rss+xml"
            :title="t('blog.feed.title', 'Flux RSS')"
            :href="'/feed.xml'"
        />
    </Head>

    <JsonLd :json="jsonLd" />

    <AppLayout>
        <section class="max-w-7xl mx-auto px-6 py-16">
            <SectionHeading
                :eyebrow="t('blog.eyebrow', '// Blog')"
                :title="t('blog.title', 'Blog')"
                :align="'center'"
            />
            <p
                v-if="t('blog.subtitle')"
                class="mt-4 text-center text-ink-light dark:text-white/70 max-w-2xl mx-auto"
            >
                {{ t('blog.subtitle') }}
            </p>

            <!-- Search -->
            <div class="mt-10 max-w-xl mx-auto">
                <label class="sr-only" for="blog-search">{{ t('blog.search.label') }}</label>
                <input
                    id="blog-search"
                    v-model="search"
                    type="search"
                    :placeholder="t('blog.search.placeholder', 'Rechercher un article...')"
                    class="w-full rounded-full border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 px-5 py-2.5 text-sm text-ink dark:text-white placeholder:text-muted focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/30"
                />
            </div>

            <!-- Filters -->
            <div class="mt-6 flex flex-col items-center gap-4">
                <div v-if="categories.length" class="flex flex-wrap items-center justify-center gap-2">
                    <span class="font-mono text-xs uppercase tracking-widest text-muted">
                        {{ t('blog.filters.categories') }}
                    </span>
                    <button
                        type="button"
                        class="rounded-full px-3 py-1 text-xs font-mono border transition-colors"
                        :class="!activeCategory
                            ? 'bg-primary text-white border-primary'
                            : 'border-border dark:border-border-dark text-ink-light dark:text-white/70 hover:border-primary hover:text-primary'"
                        @click="activeCategory = null"
                    >
                        {{ t('blog.filters.all') }}
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        type="button"
                        class="rounded-full px-3 py-1 text-xs font-mono border transition-colors"
                        :class="activeCategory === cat
                            ? 'bg-primary text-white border-primary'
                            : 'border-border dark:border-border-dark text-ink-light dark:text-white/70 hover:border-primary hover:text-primary'"
                        @click="activeCategory = activeCategory === cat ? null : cat"
                    >
                        {{ cat }}
                    </button>
                </div>

                <div v-if="tags.length" class="flex flex-wrap items-center justify-center gap-2">
                    <span class="font-mono text-xs uppercase tracking-widest text-muted">
                        {{ t('blog.filters.tags') }}
                    </span>
                    <button
                        v-for="tag in tags"
                        :key="tag"
                        type="button"
                        class="rounded-full px-3 py-1 text-xs border transition-colors"
                        :class="activeTag === tag
                            ? 'bg-teal text-white border-teal'
                            : 'border-border dark:border-border-dark text-ink-light dark:text-white/70 hover:border-teal hover:text-teal'"
                        @click="activeTag = activeTag === tag ? null : tag"
                    >
                        #{{ tag }}
                    </button>
                </div>

                <button
                    v-if="search || activeCategory || activeTag"
                    type="button"
                    class="text-xs font-mono text-muted hover:text-primary underline underline-offset-4"
                    @click="resetFilters"
                >
                    {{ t('blog.filters.reset') }}
                </button>
            </div>

            <!-- Articles grid -->
            <div v-if="paged.length" class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                <BaseCard
                    v-for="article in paged"
                    :key="article.slug"
                    class="overflow-hidden flex flex-col"
                >
                    <Link :href="`/blog/${article.slug}`" class="flex flex-col h-full">
                        <div
                            v-if="article.coverImage"
                            class="aspect-video bg-ink-light/10 dark:bg-ink-light/20 overflow-hidden"
                        >
                            <img
                                :src="article.coverImage"
                                :alt="article.title"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex flex-wrap items-center gap-2 text-xs font-mono">
                                <span
                                    v-if="article.category"
                                    class="inline-flex items-center rounded-full bg-primary/10 text-primary px-2.5 py-0.5"
                                >
                                    {{ article.category }}
                                </span>
                                <span
                                    v-for="tag in (article.tags || [])"
                                    :key="tag"
                                    class="inline-flex items-center rounded-full border border-border dark:border-border-dark px-2 py-0.5 text-muted"
                                >
                                    #{{ tag }}
                                </span>
                            </div>
                            <h3 class="mt-3 text-xl font-bold text-ink dark:text-white leading-tight">
                                {{ article.title }}
                            </h3>
                            <p
                                v-if="article.excerpt"
                                class="mt-2 text-sm text-ink-light dark:text-white/70 line-clamp-3 flex-1"
                            >
                                {{ article.excerpt }}
                            </p>
                            <div class="mt-4 flex items-center justify-between text-xs font-mono text-muted">
                                <time v-if="article.publishedAt" :datetime="article.publishedAt">
                                    {{ formatDate(article.publishedAt) }}
                                </time>
                                <span v-if="article.readingTime">
                                    {{ readingLabel(article.readingTime) }}
                                </span>
                            </div>
                        </div>
                    </Link>
                </BaseCard>
            </div>

            <!-- Empty state -->
            <div
                v-else
                class="mt-12 rounded-2xl border border-dashed border-border dark:border-border-dark p-12 text-center"
            >
                <p class="text-ink-light dark:text-white/70">
                    {{ t('blog.empty.message', 'Aucun article ne correspond à votre recherche.') }}
                </p>
                <BaseButton
                    v-if="search || activeCategory || activeTag"
                    variant="ghost"
                    class="mt-4"
                    @click="resetFilters"
                >
                    {{ t('blog.empty.reset', 'Réinitialiser les filtres') }}
                </BaseButton>
            </div>

            <!-- Pagination -->
            <nav
                v-if="totalPages > 1"
                class="mt-12 flex items-center justify-center gap-4"
                aria-label="Pagination"
            >
                <BaseButton
                    variant="secondary"
                    :disabled="currentPage <= 1"
                    @click="currentPage = Math.max(1, currentPage - 1)"
                >
                    {{ t('blog.pagination.previous', 'Précédent') }}
                </BaseButton>
                <span class="text-sm font-mono text-muted">
                    {{ t('blog.pagination.page_of', 'Page {current} / {total}')
                        .replace('{current}', String(currentPage))
                        .replace('{total}', String(totalPages)) }}
                </span>
                <BaseButton
                    variant="secondary"
                    :disabled="currentPage >= totalPages"
                    @click="currentPage = Math.min(totalPages, currentPage + 1)"
                >
                    {{ t('blog.pagination.next', 'Suivant') }}
                </BaseButton>
            </nav>
        </section>
    </AppLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import AppLayout from '@/Layouts/AppLayout.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import JsonLd from '@/Components/UI/JsonLd.vue';

const { t, locale } = useI18n();

const props = defineProps({
    article: { type: Object, required: true },
    relatedArticles: { type: Array, default: () => [] },
});

const settings = computed(() => usePage().props.settings ?? {});
const siteName = computed(() => settings.value.site_name || 'Portfolio');

const currentUrl = computed(() => {
    const u = usePage().props?.url;
    if (typeof u === 'string' && u.length > 0) return u;
    if (typeof window !== 'undefined') return window.location.href;
    return '';
});

const seoTitle = computed(() => props.article.metaTitle || props.article.title);
const seoDescription = computed(() => props.article.metaDescription || props.article.excerpt);

const coverImage = computed(() => props.article.coverImage);

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
    return t('blog.reading_time', '{n} min de lecture').replace('{n}', String(min || 1));
}

const jsonLd = computed(() => {
    const base = {
        '@context': 'https://schema.org',
    };
    const posting = {
        ...base,
        '@type': 'BlogPosting',
        headline: props.article.title,
        description: seoDescription.value,
        url: currentUrl.value,
        inLanguage: locale.value,
        datePublished: props.article.publishedAt,
        author: {
            '@type': 'Person',
            name: siteName.value,
        },
        publisher: {
            '@type': 'Person',
            name: siteName.value,
        },
        mainEntityOfPage: {
            '@type': 'WebPage',
            '@id': currentUrl.value,
        },
    };
    if (coverImage.value) {
        posting.image = coverImage.value;
    }
    if (props.article.tags && props.article.tags.length) {
        posting.keywords = props.article.tags.join(', ');
    }

    const breadcrumb = {
        ...base,
        '@type': 'BreadcrumbList',
        itemListElement: [
            {
                '@type': 'ListItem',
                position: 1,
                name: t('blog.breadcrumb.home', 'Accueil'),
                item: currentUrl.value.replace(/\/blog\/.*$/, ''),
            },
            {
                '@type': 'ListItem',
                position: 2,
                name: t('blog.breadcrumb.blog', 'Blog'),
                item: currentUrl.value.replace(/\/[^\/]*$/, ''),
            },
            {
                '@type': 'ListItem',
                position: 3,
                name: props.article.title,
                item: currentUrl.value,
            },
        ],
    };

    return [posting, breadcrumb];
});
</script>

<template>
    <Head>
        <title>{{ seoTitle }}</title>
        <meta name="description" :content="seoDescription" />
        <link rel="canonical" :href="currentUrl" />
        <meta property="og:type" content="article" />
        <meta property="og:title" :content="seoTitle" />
        <meta property="og:description" :content="seoDescription" />
        <meta property="og:url" :content="currentUrl" />
        <meta v-if="coverImage" property="og:image" :content="coverImage" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="seoTitle" />
        <meta name="twitter:description" :content="seoDescription" />
        <meta v-if="coverImage" name="twitter:image" :content="coverImage" />
        <meta v-if="article.publishedAt" property="article:published_time" :content="article.publishedAt" />
    </Head>

    <JsonLd v-for="(item, i) in jsonLd" :key="`jsonld-${i}`" :json="item" />

    <AppLayout>
        <article class="max-w-4xl mx-auto px-6 py-16">
            <BaseButton variant="ghost" :as="Link" :href="'/blog'" class="mb-8">
                <span aria-hidden="true">&larr;</span>
                {{ t('blog.show.back', 'Retour au blog') }}
            </BaseButton>

            <header class="mb-10">
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

                <h1 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-bold text-ink dark:text-white leading-tight">
                    {{ article.title }}
                </h1>

                <p
                    v-if="article.excerpt"
                    class="mt-4 text-lg text-ink-light dark:text-white/70 leading-relaxed"
                >
                    {{ article.excerpt }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm font-mono text-muted">
                    <time v-if="article.publishedAt" :datetime="article.publishedAt">
                        {{ formatDate(article.publishedAt) }}
                    </time>
                    <span v-if="article.readingTime">{{ readingLabel(article.readingTime) }}</span>
                </div>
            </header>

            <div
                v-if="coverImage"
                class="mb-10 aspect-video rounded-2xl overflow-hidden border border-border dark:border-border-dark bg-ink-light/10"
            >
                <img
                    :src="coverImage"
                    :alt="article.title"
                    class="w-full h-full object-cover"
                    loading="eager"
                />
            </div>

            <div
                class="prose prose-lg dark:prose-invert max-w-none text-ink dark:text-white leading-relaxed"
                v-html="article.content"
            />
        </article>

        <section v-if="relatedArticles.length" class="max-w-7xl mx-auto px-6 py-16">
            <h2 class="text-2xl font-bold text-ink dark:text-white mb-8">
                {{ t('blog.show.related', 'Articles similaires') }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <BaseCard
                    v-for="rel in relatedArticles"
                    :key="rel.slug"
                    class="overflow-hidden flex flex-col"
                >
                    <Link :href="`/blog/${rel.slug}`" class="flex flex-col h-full">
                        <div
                            v-if="rel.coverImage"
                            class="aspect-video bg-ink-light/10 dark:bg-ink-light/20 overflow-hidden"
                        >
                            <img
                                :src="rel.coverImage"
                                :alt="rel.title"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-base font-bold text-ink dark:text-white leading-tight">
                                {{ rel.title }}
                            </h3>
                            <p
                                v-if="rel.excerpt"
                                class="mt-2 text-sm text-ink-light dark:text-white/70 line-clamp-2 flex-1"
                            >
                                {{ rel.excerpt }}
                            </p>
                            <div class="mt-3 text-xs font-mono text-muted">
                                {{ formatDate(rel.publishedAt) }}
                            </div>
                        </div>
                    </Link>
                </BaseCard>
            </div>
        </section>
    </AppLayout>
</template>

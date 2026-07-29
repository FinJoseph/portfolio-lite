<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\SettingsRepositoryInterface;
use Illuminate\Http\Response;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function __construct(
        protected ArticleRepositoryInterface $articles,
        protected SettingsRepositoryInterface $settings,
    ) {}

    public function index()
    {
        $locale = app()->getLocale();

        $articles = $this->articles->all($locale)->map(fn ($article) => $article->toArray())->all();

        $categories = collect($articles)
            ->pluck('category')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $tags = collect($articles)
            ->pluck('tags')
            ->flatten(1)
            ->filter()
            ->unique()
            ->values()
            ->all();

        return Inertia::render('Blog/Index', [
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function show(string $slug)
    {
        $locale = app()->getLocale();

        $article = $this->articles->findBySlug($slug, $locale);

        if (! $article) {
            abort(404);
        }

        $related = $this->articles->related($article, $locale, 3)
            ->map(fn ($a) => $a->toArray())
            ->all();

        return Inertia::render('Blog/Show', [
            'article' => $article->toArray(),
            'relatedArticles' => $related,
        ]);
    }

    public function feed(): Response
    {
        $locale = app()->getLocale();
        $settings = $this->settings->get($locale);
        $articles = $this->articles->all($locale)->take(10);

        $siteUrl = rtrim(config('app.url') ?: url('/'), '/');
        $feedUrl = $siteUrl.'/feed.xml';

        $title = $settings->siteName ?: 'Portfolio';
        $description = $settings->defaultMetaDescription ?: $settings->heroDescription ?: '';

        $lastBuildDate = optional($articles->first())->publishedAt
            ? gmdate('D, d M Y H:i:s', strtotime($articles->first()->publishedAt)).' GMT'
            : gmdate('D, d M Y H:i:s').' GMT';

        $items = $articles->map(function ($article) use ($siteUrl, $locale) {
            $link = $siteUrl.'/blog/'.$article->slug;
            $pubDate = $article->publishedAt
                ? gmdate('D, d M Y H:i:s', strtotime($article->publishedAt)).' GMT'
                : gmdate('D, d M Y H:i:s').' GMT';

            return [
                'title' => $article->title,
                'link' => $link,
                'description' => $article->excerpt,
                'pubDate' => $pubDate,
                'guid' => $link,
                'category' => $article->category,
                'language' => $locale,
            ];
        })->all();

        $xml = view('feed.rss', [
            'title' => $title,
            'description' => $description,
            'siteUrl' => $siteUrl,
            'feedUrl' => $feedUrl,
            'lastBuildDate' => $lastBuildDate,
            'language' => $locale,
            'items' => $items,
        ])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/rss+xml; charset=utf-8',
        ]);
    }
}

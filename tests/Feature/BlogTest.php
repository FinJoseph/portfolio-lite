<?php

use App\Repositories\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    Cache::flush();
    app()->setLocale('fr');

    $this->testPath = storage_path('framework/testing/blog-content');
    File::ensureDirectoryExists($this->testPath);

    File::put($this->testPath.'/post-1.fr.md', <<<'MD'
---
title: "Article Un"
slug: "article-un"
excerpt: "Excerpt un"
category: "backend"
tags: ["Laravel", "PHP"]
status: "published"
published_at: "2026-06-01"
reading_time: 5
order: 1
meta_title: "Article Un - Meta"
meta_description: "Meta un"
---

Contenu article un.
MD);

    File::put($this->testPath.'/post-2.fr.md', <<<'MD'
---
title: "Article Deux"
slug: "article-deux"
excerpt: "Excerpt deux"
category: "frontend"
tags: ["Vue"]
status: "published"
published_at: "2026-06-15"
reading_time: 3
order: 2
---

Contenu article deux.
MD);

    File::put($this->testPath.'/draft.fr.md', <<<'MD'
---
title: "Brouillon"
slug: "brouillon"
excerpt: "Ne doit pas apparaître"
category: "backend"
tags: ["Laravel"]
status: "draft"
published_at: null
reading_time: 1
order: 99
---

Brouillon.
MD);

    // Rebind the repository to use the test path
    $this->app->instance(
        ArticleRepositoryInterface::class,
        new \App\Repositories\FileArticleRepository($this->testPath),
    );
});

afterEach(function () {
    File::deleteDirectory($this->testPath);
});

it('affiche la page index du blog avec les articles, catégories et tags', function () {
    $response = $this->get('/blog');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Blog/Index')
        ->has('articles', 2)
        ->has('categories', 2)
        ->has('tags', 3)
    );
});

it("n'inclut pas les brouillons dans la liste publique", function () {
    $response = $this->get('/blog');

    $response->assertInertia(fn ($page) => $page
        ->where('articles.0.slug', 'article-deux')
        ->where('articles.1.slug', 'article-un')
    );
});

it('affiche la page show d\'un article existant avec ses articles similaires', function () {
    $response = $this->get('/blog/article-un');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Blog/Show')
        ->where('article.slug', 'article-un')
        ->where('article.title', 'Article Un')
        ->has('relatedArticles')
    );
});

it('retourne 404 pour un article inexistant', function () {
    $this->get('/blog/article-inexistant')->assertStatus(404);
});

it('sert un flux RSS 2.0 valide avec le bon content-type', function () {
    $response = $this->get('/feed.xml');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/rss+xml; charset=utf-8');

    $content = $response->getContent();
    expect($content)->toContain('<rss');
    expect($content)->toContain('<channel>');
    expect($content)->toContain('Article Deux');
    expect($content)->toContain('Article Un');
    // Brouillon ne doit PAS apparaître dans le flux
    expect($content)->not->toContain('Brouillon');
});

it('ne dépasse pas 10 articles dans le flux RSS', function () {
    $response = $this->get('/feed.xml');
    $content = $response->getContent();

    // Compte les balises <item>
    $count = substr_count($content, '<item>');
    expect($count)->toBeLessThanOrEqual(10);
});

it('expose les routes blog.index, blog.show et blog.feed', function () {
    expect(route('blog.index'))->toContain('/blog');
    expect(route('blog.show', 'mon-slug'))->toContain('/blog/mon-slug');
    expect(route('blog.feed'))->toContain('/feed.xml');
});

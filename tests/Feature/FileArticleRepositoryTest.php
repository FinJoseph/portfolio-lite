<?php

use App\Repositories\FileArticleRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    Cache::flush();

    $this->testPath = storage_path('framework/testing/content-articles');
    File::ensureDirectoryExists($this->testPath);

    // Article 1 : publié, tags Laravel/PHP
    File::put($this->testPath.'/article-1.fr.md', <<<'MD'
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
---

Contenu article un.
MD
    );

    // Article 2 : publié, partage le tag "Laravel" avec l'article 1 → doit être "related"
    File::put($this->testPath.'/article-2.fr.md', <<<'MD'
---
title: "Article Deux"
slug: "article-deux"
excerpt: "Excerpt deux"
category: "frontend"
tags: ["Laravel", "Vue"]
status: "published"
published_at: "2026-06-15"
reading_time: 3
order: 2
---

Contenu article deux.
MD
    );

    // Article 3 : publié, aucun tag ni catégorie commune → ne doit PAS être "related" à l'article 1
    File::put($this->testPath.'/article-3.fr.md', <<<'MD'
---
title: "Article Trois"
slug: "article-trois"
excerpt: "Excerpt trois"
category: "design"
tags: ["Figma"]
status: "published"
published_at: "2026-06-20"
reading_time: 2
order: 3
---

Contenu article trois.
MD
    );

    // Article 4 : brouillon (draft) → ne doit JAMAIS apparaître dans all()
    File::put($this->testPath.'/article-4.fr.md', <<<'MD'
---
title: "Article Brouillon"
slug: "article-brouillon"
excerpt: "Ne doit pas être visible"
category: "backend"
tags: ["Laravel"]
status: "draft"
published_at: null
reading_time: 1
order: 4
---

Contenu brouillon.
MD
    );
});

afterEach(function () {
    File::deleteDirectory($this->testPath);
});

it('ne retourne que les articles publiés', function () {
    $repository = new FileArticleRepository($this->testPath);

    $articles = $repository->all('fr');

    expect($articles)->toHaveCount(3);
    expect($articles->pluck('title'))->not->toContain('Article Brouillon');
});

it('trie les articles du plus récent au plus ancien', function () {
    $repository = new FileArticleRepository($this->testPath);

    $articles = $repository->all('fr');

    // Article Trois (20 juin) doit être avant Article Un (1er juin)
    expect($articles->first()->title)->toBe('Article Trois');
    expect($articles->last()->title)->toBe('Article Un');
});

it('peut retrouver un article par son slug', function () {
    $repository = new FileArticleRepository($this->testPath);

    $article = $repository->findBySlug('article-un', 'fr');

    expect($article)->not->toBeNull();
    expect($article->readingTime)->toBe(5);
});

it('retourne null si le slug n\'existe pas', function () {
    $repository = new FileArticleRepository($this->testPath);

    $article = $repository->findBySlug('inexistant', 'fr');

    expect($article)->toBeNull();
});

it('trouve les articles similaires par tag partagé', function () {
    $repository = new FileArticleRepository($this->testPath);

    $article1 = $repository->findBySlug('article-un', 'fr');
    $related = $repository->related($article1, 'fr');

    // Article Deux partage le tag "Laravel" avec Article Un → doit apparaître
    expect($related->pluck('slug'))->toContain('article-deux');
    // Article Trois n'a aucun tag/catégorie commun → ne doit PAS apparaître
    expect($related->pluck('slug'))->not->toContain('article-trois');
});

it('exclut l\'article lui-même de ses propres similaires', function () {
    $repository = new FileArticleRepository($this->testPath);

    $article1 = $repository->findBySlug('article-un', 'fr');
    $related = $repository->related($article1, 'fr');

    expect($related->pluck('slug'))->not->toContain('article-un');
});

it('respecte la limite du nombre d\'articles similaires', function () {
    $repository = new FileArticleRepository($this->testPath);

    $article1 = $repository->findBySlug('article-un', 'fr');
    $related = $repository->related($article1, 'fr', limit: 1);

    expect($related)->toHaveCount(1);
});

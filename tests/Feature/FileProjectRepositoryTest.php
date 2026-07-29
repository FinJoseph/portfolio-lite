<?php

use App\Repositories\FileProjectRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    Cache::flush();

    $this->testPath = storage_path('framework/testing/content-projects');
    File::ensureDirectoryExists($this->testPath);

    File::put($this->testPath.'/exemple.fr.md', <<<'MD'
---
title: "Projet Test"
slug: "projet-test"
excerpt: "Un excerpt de test"
cover_image: "/images/test/cover.jpg"
gallery:
  - "/images/test/screen-1.jpg"
  - "/images/test/screen-2.jpg"
category: "web"
technologies: ["PHP"]
site_url: "https://demo.test"
github_url: "https://github.com/test/projet-test"
completed_at: "2026-01-15"
status: "completed"
is_featured: false
order: 1
meta_title: "Projet Test - Meta"
meta_description: "Description meta du projet test"
---

Contenu de test.
MD
    );

    // Un deuxième fichier SANS les nouveaux champs optionnels,
    // pour vérifier la rétrocompatibilité (anciens fichiers déjà existants)
    File::put($this->testPath.'/minimal.fr.md', <<<'MD'
---
title: "Projet Minimal"
slug: "projet-minimal"
excerpt: "Excerpt minimal"
technologies: []
status: "draft"
is_featured: false
order: 2
---

Contenu minimal.
MD
    );
});

afterEach(function () {
    File::deleteDirectory($this->testPath);
});

it('peut lire et parser un fichier projet markdown', function () {
    $repository = new FileProjectRepository($this->testPath);

    $projects = $repository->all('fr');

    expect($projects)->toHaveCount(2);
    expect($projects->first()->title)->toBe('Projet Test');
    expect($projects->first()->slug)->toBe('projet-test');
});

it('peut retrouver un projet par son slug', function () {
    $repository = new FileProjectRepository($this->testPath);

    $project = $repository->findBySlug('projet-test', 'fr');

    expect($project)->not->toBeNull();
    expect($project->excerpt)->toBe('Un excerpt de test');
});

it('retourne null si le slug n\'existe pas', function () {
    $repository = new FileProjectRepository($this->testPath);

    $project = $repository->findBySlug('slug-inexistant', 'fr');

    expect($project)->toBeNull();
});

it('convertit correctement le markdown en html', function () {
    $repository = new FileProjectRepository($this->testPath);

    $project = $repository->findBySlug('projet-test', 'fr');

    expect($project->content)->toContain('<p>Contenu de test.</p>');
});

it('lit correctement les nouveaux champs enrichis', function () {
    $repository = new FileProjectRepository($this->testPath);

    $project = $repository->findBySlug('projet-test', 'fr');

    expect($project->coverImage)->toBe('/images/test/cover.jpg');
    expect($project->gallery)->toHaveCount(2);
    expect($project->category)->toBe('web');
    expect($project->siteUrl)->toBe('https://demo.test');
    expect($project->githubUrl)->toBe('https://github.com/test/projet-test');
    expect($project->completedAt)->toBe('2026-01-15');
    expect($project->metaTitle)->toBe('Projet Test - Meta');
});

it('applique des valeurs par défaut si les champs enrichis sont absents', function () {
    $repository = new FileProjectRepository($this->testPath);

    $project = $repository->findBySlug('projet-minimal', 'fr');

    // Un ancien fichier sans ces champs ne doit jamais planter le site
    expect($project->coverImage)->toBeNull();
    expect($project->gallery)->toBe([]);
    expect($project->category)->toBe('web');
    expect($project->siteUrl)->toBeNull();
    expect($project->githubUrl)->toBeNull();
    expect($project->completedAt)->toBeNull();
    // meta_title absent → doit se replier sur le titre du projet
    expect($project->metaTitle)->toBe('Projet Minimal');
});

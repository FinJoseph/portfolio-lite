<?php

use App\Repositories\JsonSettingsRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    Cache::flush();

    $this->testPath = storage_path('framework/testing/settings-test.json');

    File::ensureDirectoryExists(dirname($this->testPath));

    File::put($this->testPath, json_encode([
        'site_name' => 'Portfolio Test',
        'job_title' => [
            'fr' => 'Développeur Web',
            'en' => 'Web Developer',
        ],
        'hero_headline' => [
            'fr' => 'Bonjour, je suis [name]',
            'en' => 'Hi, I\'m [name]',
        ],
        'hero_tagline' => [
            'fr' => 'Je conçois des expériences web.',
            'en' => 'I build web experiences.',
        ],
        'hero_description' => [
            'fr' => 'Bio courte FR.',
            'en' => 'Short bio EN.',
        ],
        'hero_cta_primary' => [
            'fr' => 'Voir les projets',
            'en' => 'See projects',
        ],
        'hero_cta_secondary' => [
            'fr' => 'Contacter',
            'en' => 'Contact',
        ],
        'availability_badge' => [
            'fr' => 'Disponible',
            'en' => 'Available',
        ],
        'bio' => [
            'fr' => 'Bio en français.',
            'en' => 'Bio in English.',
        ],
        'avatar' => '/images/avatar-test.jpg',
        'email' => 'test@example.com',
        'phone' => '+261 34 00 000 00',
        'social_links' => [
            'github' => 'https://github.com/test',
            'linkedin' => null,
        ],
        'default_meta_title' => [
            'fr' => 'Titre Meta FR',
            'en' => 'Meta Title EN',
        ],
        'default_meta_description' => [
            'fr' => 'Description meta FR',
            'en' => 'Meta description EN',
        ],
    ]));
});

afterEach(function () {
    File::delete($this->testPath);
});

it('lit correctement les settings dans la langue demandée', function () {
    $repository = new JsonSettingsRepository($this->testPath);

    $settings = $repository->get('en');

    expect($settings->siteName)->toBe('Portfolio Test');
    expect($settings->jobTitle)->toBe('Web Developer');
    expect($settings->heroTagline)->toBe('I build web experiences.');
    expect($settings->bio)->toBe('Bio in English.');
    expect($settings->email)->toBe('test@example.com');
});

it('se replie sur le français si la langue demandée n\'existe pas', function () {
    $repository = new JsonSettingsRepository($this->testPath);

    $settings = $repository->get('mg');

    expect($settings->jobTitle)->toBe('Développeur Web');
    expect($settings->bio)->toBe('Bio en français.');
});

it('retourne les liens sociaux tels quels, y compris les valeurs null', function () {
    $repository = new JsonSettingsRepository($this->testPath);

    $settings = $repository->get('fr');

    expect($settings->socialLinks['github'])->toBe('https://github.com/test');
    expect($settings->socialLinks['linkedin'])->toBeNull();
});

it('lit avatar et phone correctement', function () {
    $repository = new JsonSettingsRepository($this->testPath);

    $settings = $repository->get('fr');

    expect($settings->avatar)->toBe('/images/avatar-test.jpg');
    expect($settings->phone)->toBe('+261 34 00 000 00');
});

it('lit les meta SEO par défaut dans la bonne langue', function () {
    $repository = new JsonSettingsRepository($this->testPath);

    $settings = $repository->get('en');

    expect($settings->defaultMetaTitle)->toBe('Meta Title EN');
    expect($settings->defaultMetaDescription)->toBe('Meta description EN');
});

it('retourne des valeurs par défaut si le fichier n\'existe pas', function () {
    $repository = new JsonSettingsRepository(storage_path('framework/testing/inexistant.json'));

    $settings = $repository->get('fr');

    expect($settings->siteName)->toBe('Portfolio');
    expect($settings->email)->toBe('');
    expect($settings->avatar)->toBeNull();
    expect($settings->phone)->toBeNull();
    expect($settings->socialLinks)->toBe([]);
});

it('lit les champs dédiés au hero dans la bonne langue', function () {
    $repository = new JsonSettingsRepository($this->testPath);

    $settings = $repository->get('en');

    expect($settings->heroHeadline)->toBe('Hi, I\'m [name]');
    expect($settings->heroTagline)->toBe('I build web experiences.');
    expect($settings->heroDescription)->toBe('Short bio EN.');
    expect($settings->heroCtaPrimary)->toBe('See projects');
    expect($settings->heroCtaSecondary)->toBe('Contact');
    expect($settings->availabilityBadge)->toBe('Available');
});

<?php

use App\Events\ContactMessageSubmitted;
use App\Mail\ContactMail;
use App\Repositories\SettingsRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Cache::flush();
});

it('affiche la page de contact', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Contact', false));
});

it('envoie un email avec des données valides', function () {
    Mail::fake();

    $settings = app(SettingsRepositoryInterface::class)->get(app()->getLocale());

    $response = $this->post('/contact', [
        'name' => 'Jean Dupont',
        'email' => 'jean@example.com',
        'subject' => 'Sujet de test',
        'message' => 'Ceci est un message de test suffisamment long.',
        'website' => '',
    ]);

    $response->assertRedirect('/contact');
    $response->assertSessionHas('success', true);
    Mail::assertSent(ContactMail::class, function ($mail) use ($settings) {
        return $mail->hasTo($settings->email)
            && $mail->email === 'jean@example.com';
    });
});

it('dispatche un événement ContactMessageSubmitted lors d\'une soumission valide', function () {
    Event::fake([ContactMessageSubmitted::class]);

    $this->post('/contact', [
        'name' => 'Jean Dupont',
        'email' => 'jean@example.com',
        'subject' => 'Sujet de test',
        'message' => 'Ceci est un message de test suffisamment long.',
        'website' => '',
    ])->assertRedirect('/contact');

    Event::assertDispatched(ContactMessageSubmitted::class, function ($event) {
        return $event->name === 'Jean Dupont'
            && $event->email === 'jean@example.com'
            && $event->subject === 'Sujet de test';
    });
});

it('valide les champs requis', function () {
    $response = $this->post('/contact', []);

    $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
});

it('rejette un email invalide', function () {
    $response = $this->post('/contact', [
        'name' => 'Jean',
        'email' => 'pas-un-email',
        'subject' => 'Sujet',
        'message' => 'Message assez long pour passer la validation.',
    ]);

    $response->assertSessionHasErrors(['email']);
});

it('bloque le champ honeypot', function () {
    $response = $this->post('/contact', [
        'name' => 'Jean',
        'email' => 'jean@example.com',
        'subject' => 'Sujet',
        'message' => 'Message assez long pour passer la validation.',
        'website' => 'https://spam.example.com',
    ]);

    $response->assertSessionHasErrors(['website']);
});

it('limite les soumissions avec le throttle', function () {
    $payload = [
        'name' => 'Jean',
        'email' => 'jean@example.com',
        'subject' => 'Sujet',
        'message' => 'Message assez long pour passer la validation.',
    ];

    for ($i = 0; $i < 5; $i++) {
        $this->post('/contact', $payload)->assertRedirect('/contact');
    }

    $this->post('/contact', $payload)->assertStatus(429);
});

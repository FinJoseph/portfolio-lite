<?php

namespace App\Listeners;

use App\Events\ContactMessageSubmitted;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWebhookNotification
{
    public function handle(ContactMessageSubmitted $event): void
    {
        $webhookUrl = config('services.webhook.url');

        if (! $webhookUrl) {
            return;
        }

        $payload = [
            'content' => null,
            'embeds' => [
                [
                    'title' => 'Nouveau message de contact',
                    'color' => 0xc97a2b,
                    'fields' => [
                        ['name' => 'Nom', 'value' => $event->name, 'inline' => true],
                        ['name' => 'Email', 'value' => $event->email, 'inline' => true],
                        ['name' => 'Sujet', 'value' => $event->subject, 'inline' => false],
                        ['name' => 'Message', 'value' => substr($event->message, 0, 1000), 'inline' => false],
                    ],
                    'timestamp' => now()->toIso8601String(),
                ],
            ],
        ];

        try {
            Http::timeout(5)->post($webhookUrl, $payload);
        } catch (\Exception $e) {
            Log::warning('Webhook notification failed: '.$e->getMessage());
        }
    }
}

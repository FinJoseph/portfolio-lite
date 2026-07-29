<?php

namespace App\Listeners;

use App\Events\ContactMessageSubmitted;
use Illuminate\Support\Facades\Log;

class LogContactMessage
{
    public function handle(ContactMessageSubmitted $event): void
    {
        Log::channel('contact')->info('Contact message submitted', [
            'name' => $event->name,
            'email' => $event->email,
            'subject' => $event->subject,
            'message_length' => strlen($event->message),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

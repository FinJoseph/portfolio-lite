<?php

namespace App\Listeners;

use App\Events\ContactMessageSubmitted;
use App\Mail\ContactMail;
use App\Repositories\SettingsRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    public function __construct(
        protected SettingsRepositoryInterface $settings,
    ) {
    }

    public function handle(ContactMessageSubmitted $event): void
    {
        $settings = $this->settings->get(app()->getLocale());

        Mail::to($settings->email)->send(new ContactMail(
            name: $event->name,
            email: $event->email,
            subjectLine: $event->subject,
            message: $event->message,
        ));
    }
}

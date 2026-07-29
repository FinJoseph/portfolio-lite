<?php

namespace App\Http\Controllers;

use App\Events\ContactMessageSubmitted;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index(): Response
    {
        return Inertia::render('Contact');
    }

    /**
     * Handle a submitted contact form.
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        ContactMessageSubmitted::dispatch(
            name: $validated['name'],
            email: $validated['email'],
            subject: $validated['subject'],
            message: $validated['message'],
        );

        return redirect()->route('contact')->with('success', true);
    }
}

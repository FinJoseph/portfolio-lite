@component('mail::message')
# New contact message

You have received a new message from the contact form.

@component('mail::panel')
**From:** {{ $name }} <{{ $email }}>

**Subject:** {{ $subjectLine }}
@endcomponent

## Message

{{ $message }}

@component('mail::subcopy')
Reply directly to this email to respond to {{ $name }}.
@endcomponent
@endcomponent

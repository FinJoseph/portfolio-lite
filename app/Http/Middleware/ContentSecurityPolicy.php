<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $viteHost = app()->environment('local') ? 'localhost:5173 127.0.0.1:5173' : '';

        $scriptSrc = "'self' 'unsafe-inline' 'unsafe-eval' {$viteHost}";
        $styleSrc = "'self' 'unsafe-inline' https://fonts.googleapis.com {$viteHost}";
        $connectSrc = "'self' https: ws://localhost:5173 ws://127.0.0.1:5173";

        $csp = "default-src 'self'; "
            ."script-src {$scriptSrc}; "
            ."style-src {$styleSrc}; "
            ."font-src 'self' https://fonts.gstatic.com; "
            ."img-src 'self' data: blob: https:; "
            ."connect-src {$connectSrc}; "
            ."frame-src 'none'; "
            ."object-src 'none'; "
            ."base-uri 'self'";

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}

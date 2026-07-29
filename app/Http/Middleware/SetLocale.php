<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Locales supportées par l'application.
     * Doit rester synchronisé avec les fichiers dans resources/js/i18n/locales/.
     */
    protected array $supported = ['fr', 'en', 'mg'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);

        if ($locale !== null) {
            App::setLocale($locale);
        }

        return $next($request);
    }

    /**
     * Résout la locale à utiliser pour cette requête, dans l'ordre de priorité :
     *  1. Prefixe d'URL `/{locale}/...` si présent
     *  2. Cookie `locale` (persisté par le LocaleSwitcher côté client)
     *  3. Header `X-Locale` envoyé par Inertia sur les navigations SPA
     *  4. Locale par défaut de l'application (config/app.php)
     */
    protected function resolveLocale(Request $request): ?string
    {
        $firstSegment = $request->segment(1);

        if (in_array($firstSegment, $this->supported, true)) {
            return $firstSegment;
        }

        $cookieLocale = $request->cookie('locale');
        if (is_string($cookieLocale) && in_array($cookieLocale, $this->supported, true)) {
            return $cookieLocale;
        }

        $headerLocale = $request->header('X-Locale');
        if (is_string($headerLocale) && in_array($headerLocale, $this->supported, true)) {
            return $headerLocale;
        }

        return null;
    }
}

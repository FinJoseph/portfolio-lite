<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalePersistenceTest extends TestCase
{
    /**
     * Le cookie 'locale' défini côté client doit être lisible par le
     * middleware SetLocale après un refresh complet de la page.
     */
    public function test_locale_cookie_persists_on_full_page_refresh(): void
    {
        $response = $this->withUnencryptedCookie('locale', 'mg')
            ->get('/');

        $response->assertStatus(200);
        $this->assertSame('mg', app()->getLocale());
    }
}

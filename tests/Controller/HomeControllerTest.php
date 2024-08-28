<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Vérifie que la réponse est correcte
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Zoo Arcadia');
        $this->assertSelectorExists('.pageContainer');
    }
}
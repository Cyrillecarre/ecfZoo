<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Zoo Arcadia');
        $this->assertSelectorExists('.pageContainer');
        $this->assertSelectorExists('.container2');
        $this->assertSelectorExists('.plan');
        $this->assertSelectorExists('.container3');
    }

    public function testHeaderIsPresent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('div.header');
        $this->assertSelectorExists('nav.navBarre');
    }

    public function testFooterIsPresent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('footer .footerContent');
    }
}
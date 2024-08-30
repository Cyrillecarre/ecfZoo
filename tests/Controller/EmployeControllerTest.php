<?php
namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeControllerTest extends WebTestCase
{
    private function authenticateAsEmploye($client): void
    {
        $user = [
            'email' => 'lowen@gmail.com',
            'password' => 'lowen1',
        ];

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(0, $crawler->filter('input[name="email"]')->count(), 'Email field not found');
        $this->assertGreaterThan(0, $crawler->filter('input[name="password"]')->count(), 'Password field not found');
        $this->assertGreaterThan(0, $crawler->filter('button[type="submit"]')->count(), 'Submit button not found');

        $form = $crawler->selectButton('Connexion')->form([
            'email' => $user['email'],
            'password' => $user['password'],
            '_csrf_token' => $crawler->filter('input[name="_csrf_token"]')->attr('value'),
        ]);

        $client->submit($form);
        $client->followRedirect();
    }

    public function testIndexEmploye(): void
    {
        $client = static::createClient();
        $this->authenticateAsEmploye($client);

        $client->request('GET', '/employe/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.header');
        $this->assertSelectorExists('.topBarLogo');
        $this->assertSelectorExists('.logo');
        $this->assertSelectorExists('.top-bar');
        $this->assertSelectorExists('.top-nav');
        $this->assertSelectorExists('.main-container');
        $this->assertSelectorExists('.sidebar');
        $this->assertSelectorExists('.sidebar-nav');
        $this->assertSelectorExists('.content');
    }

    public function testIndexTropical(): void
    {
        $client = static::createClient();
        $this->authenticateAsEmploye($client);

        $client->request('GET', '/employe/tropical');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.gridContainer');
        $this->assertSelectorExists('.details-container');
        $this->assertSelectorExists('.containerImg');
        $this->assertSelectorExists('.detail-item');
        $this->assertSelectorExists('.label');
        $this->assertSelectorExists('.value');
    }

    public function testIndexSavane(): void
    {
        $client = static::createClient();
        $this->authenticateAsEmploye($client);

        $client->request('GET', '/employe/savane');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.gridContainer');
        $this->assertSelectorExists('.details-container');
        $this->assertSelectorExists('.containerImg');
        $this->assertSelectorExists('.detail-item');
        $this->assertSelectorExists('.label');
        $this->assertSelectorExists('.value');
    }
    public function testIndexDesert(): void
    {
        $client = static::createClient();
        $this->authenticateAsEmploye($client);

        $client->request('GET', '/employe/savane');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.gridContainer');
        $this->assertSelectorExists('.details-container');
        $this->assertSelectorExists('.containerImg');
        $this->assertSelectorExists('.detail-item');
        $this->assertSelectorExists('.label');
        $this->assertSelectorExists('.value');
    }
    public function testIndexPointsante(): void
    {
        $client = static::createClient();
        $this->authenticateAsEmploye($client);

        $client->request('GET', '/employe/pointsante');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.titre');
        $this->assertSelectorExists('.animal-card');
        $this->assertSelectorExists('.animal-header');
        $this->assertSelectorExists('.card-container');
        $this->assertSelectorExists('.veterinary-card');
        $this->assertSelectorExists('.employee-card');
    }
}
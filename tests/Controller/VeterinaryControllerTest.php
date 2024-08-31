<?php
namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VeterinaryControllerTest extends WebTestCase
{
    private function authenticateAsVeterinary($client): void
    {
        $user = [
            'email' => 'swan@gmail.com',
            'password' => 'swan12',
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
        $this->authenticateAsVeterinary($client);

        $client->request('GET', '/veterinary/');

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
        $this->authenticateAsVeterinary($client);

        $client->request('GET', '/veterinary/tropical');

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
        $this->authenticateAsVeterinary($client);

        $client->request('GET', '/veterinary/savane');

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
        $this->authenticateAsVeterinary($client);

        $client->request('GET', '/veterinary/savane');

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
        $this->authenticateAsVeterinary($client);

        $client->request('GET', '/veterinary/veterinaire/pointsante');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.titre');
        $this->assertSelectorExists('.animal-card');
        $this->assertSelectorExists('.animal-header');
        $this->assertSelectorExists('.card-container');
        $this->assertSelectorExists('.veterinary-card');
        $this->assertSelectorExists('.employee-card');
    }

    public function testDashboard(): void
    {
        $client = static::createClient();
        $this->authenticateAsVeterinary($client);
        
        $client->request('GET', '/dashboard');
        
        $this->assertSelectorExists('.titre');
        $this->assertSelectorExists('.chart-container');
        $this->assertSelectorExists('.flex-container');
    }
}
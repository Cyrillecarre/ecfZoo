<?php
namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    private function authenticateAsAdmin($client): void
    {
        $user = [
            'email' => 'cyrille@gmail.com',
            'password' => 'cyrille',
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

    public function testAdminIndex(): void
    {
        $client = static::createClient();
    
        // Authentifier l'utilisateur
        $this->authenticateAsAdmin($client);
        
        // Accéder à la page admin
        $client->request('GET', '/admin');
        
        $this->assertResponseIsSuccessful();
    }
}
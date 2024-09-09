<?php
namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ServiceControllerTest extends WebTestCase
{
    private $uploadsDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uploadsDir = __DIR__ . '/fixtures/uploads';
    }
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

    public function testIndexService(): void
    {
        $client = static::createClient();
        $this->authenticateAsAdmin($client);

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.prestation');
        $this->assertSelectorExists('.titrePrestation');
        $this->assertSelectorExists('.article2');
        $this->assertSelectorExists('.service-item');
        $this->assertSelectorExists('.titrePrestationContent');
        $this->assertSelectorExists('.text');
        $this->assertSelectorExists('.contentPrestationRestauration');
    }

    public function testCreateService(): void
    {
    $client = static::createClient();
    $this->authenticateAsAdmin($client);

    $crawler = $client->request('GET', '/service/new');
    
    $uploadedFile = new \Symfony\Component\HttpFoundation\File\UploadedFile(
        __DIR__.'/fixtures/uploads/areaS1.jpg',
        'areaS1.jpg',
        'image/jpeg',
        null,
        true 
    );

    $form = $crawler->selectButton('Save')->form([
        'service[name]' => 'Service Test With Image',
        'service[descritpion]' => 'Description du service avec image',
        'service[picture]' => $uploadedFile,
    ]);

    $client->submit($form);

    $this->assertResponseRedirects('/service/');

    $client->followRedirect();

    // $imagePath = $this->uploadsDir . '/areaS1.jpg';
    //    if (file_exists($imagePath)) {
    //        unlink($imagePath);
    //    }
    }
}

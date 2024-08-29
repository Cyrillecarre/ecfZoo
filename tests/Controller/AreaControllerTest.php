<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\AnimalCountController;

class AreaControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testArea1(): void
{
    $client = static::createClient();

    // Créer le mock pour AnimalCountController
    $mockAnimalCountController = $this->createMock(AnimalCountController::class);
    
    // Configurer les méthodes individuellement
    $mockAnimalCountController->method('show')
        ->willReturn(new Response('Mocked response', 200));
    
    $mockAnimalCountController->method('incrementCounter')
        ->willReturn(new Response('Mocked response', 200));

    // Injecter le mock dans le container
    $client->getContainer()->set(AnimalCountController::class, $mockAnimalCountController);

    // Effectuer la requête
    $crawler = $client->request('GET', '/area1');
    
    // Vérifier la réponse
    $this->assertResponseIsSuccessful();
    $this->assertSelectorExists('.mainArea');
}

public function testArea2(): void
{
    $client = static::createClient();

    $mockAnimalCountController = $this->createMock(AnimalCountController::class);
    
    $mockAnimalCountController->method('show')
        ->willReturn(new Response('Mocked response', 200));
    
    $mockAnimalCountController->method('incrementCounter')
        ->willReturn(new Response('Mocked response', 200));

    $client->getContainer()->set(AnimalCountController::class, $mockAnimalCountController);
    
    $crawler = $client->request('GET', '/area2');
    
    $this->assertResponseIsSuccessful();
    $this->assertSelectorExists('.mainArea');
}

public function testArea3(): void
{
    $client = static::createClient();

    $mockAnimalCountController = $this->createMock(AnimalCountController::class);
    
    $mockAnimalCountController->method('show')
        ->willReturn(new Response('Mocked response', 200));
    
    $mockAnimalCountController->method('incrementCounter')
        ->willReturn(new Response('Mocked response', 200));

    $client->getContainer()->set(AnimalCountController::class, $mockAnimalCountController);
    
    $crawler = $client->request('GET', '/area3');
    
    $this->assertResponseIsSuccessful();
    $this->assertSelectorExists('.mainArea');
}
}
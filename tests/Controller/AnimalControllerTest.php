<?php

namespace App\Test\Controller;

use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Area;

class AnimalControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/animal/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Animal::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
{
    // Simulez une réponse réussie pour le test
    $crawler = $this->client->request('GET', $this->path);

    // Vérifiez le code de statut de la réponse
    self::assertResponseIsSuccessful();
    self::assertPageTitleContains('Animal index');

    // Assurez-vous que le contenu ne contient pas d'erreurs
    self::assertSelectorTextContains('h1', 'Expected Title'); // Exemple : vérifier un titre spécifique

    // Vérifiez la présence d'autres éléments
    self::assertGreaterThan(0, $crawler->filter('.animal-item')->count()); // Exemple : vérifier la présence des animaux
}
}

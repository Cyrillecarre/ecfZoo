<?php

namespace App\Test\Controller;

use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Animal index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'animal[name]' => 'Testing',
            'animal[race]' => 'Testing',
            'animal[Area]' => 'Testing',
            'animal[recommandationVeterinary]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Animal();
        $fixture->setName('My Title');
        $fixture->setRace('My Title');
        $fixture->setArea('My Title');
        $fixture->setRecommandationVeterinary('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Animal');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Animal();
        $fixture->setName('Value');
        $fixture->setRace('Value');
        $fixture->setArea('Value');
        $fixture->setRecommandationVeterinary('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'animal[name]' => 'Something New',
            'animal[race]' => 'Something New',
            'animal[Area]' => 'Something New',
            'animal[recommandationVeterinary]' => 'Something New',
        ]);

        self::assertResponseRedirects('/animal/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getRace());
        self::assertSame('Something New', $fixture[0]->getArea());
        self::assertSame('Something New', $fixture[0]->getRecommandationVeterinary());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Animal();
        $fixture->setName('Value');
        $fixture->setRace('Value');
        $fixture->setArea('Value');
        $fixture->setRecommandationVeterinary('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/animal/');
        self::assertSame(0, $this->repository->count([]));
    }
}

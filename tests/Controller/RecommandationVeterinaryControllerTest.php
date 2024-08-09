<?php

namespace App\Test\Controller;

use App\Entity\RecommandationVeterinary;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecommandationVeterinaryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/recommandation/veterinary/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(RecommandationVeterinary::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RecommandationVeterinary index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'recommandation_veterinary[food]' => 'Testing',
            'recommandation_veterinary[quantity]' => 'Testing',
            'recommandation_veterinary[medicine]' => 'Testing',
            'recommandation_veterinary[date]' => 'Testing',
            'recommandation_veterinary[state]' => 'Testing',
            'recommandation_veterinary[recommandation]' => 'Testing',
            'recommandation_veterinary[report]' => 'Testing',
            'recommandation_veterinary[Animal]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RecommandationVeterinary();
        $fixture->setFood('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setMedicine('My Title');
        $fixture->setDate('My Title');
        $fixture->setState('My Title');
        $fixture->setRecommandation('My Title');
        $fixture->setReport('My Title');
        $fixture->setAnimal('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RecommandationVeterinary');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RecommandationVeterinary();
        $fixture->setFood('Value');
        $fixture->setQuantity('Value');
        $fixture->setMedicine('Value');
        $fixture->setDate('Value');
        $fixture->setState('Value');
        $fixture->setRecommandation('Value');
        $fixture->setReport('Value');
        $fixture->setAnimal('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'recommandation_veterinary[food]' => 'Something New',
            'recommandation_veterinary[quantity]' => 'Something New',
            'recommandation_veterinary[medicine]' => 'Something New',
            'recommandation_veterinary[date]' => 'Something New',
            'recommandation_veterinary[state]' => 'Something New',
            'recommandation_veterinary[recommandation]' => 'Something New',
            'recommandation_veterinary[report]' => 'Something New',
            'recommandation_veterinary[Animal]' => 'Something New',
        ]);

        self::assertResponseRedirects('/recommandation/veterinary/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFood());
        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getMedicine());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getState());
        self::assertSame('Something New', $fixture[0]->getRecommandation());
        self::assertSame('Something New', $fixture[0]->getReport());
        self::assertSame('Something New', $fixture[0]->getAnimal());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new RecommandationVeterinary();
        $fixture->setFood('Value');
        $fixture->setQuantity('Value');
        $fixture->setMedicine('Value');
        $fixture->setDate('Value');
        $fixture->setState('Value');
        $fixture->setRecommandation('Value');
        $fixture->setReport('Value');
        $fixture->setAnimal('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/recommandation/veterinary/');
        self::assertSame(0, $this->repository->count([]));
    }
}

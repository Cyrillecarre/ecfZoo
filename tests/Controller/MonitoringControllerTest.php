<?php

namespace App\Test\Controller;

use App\Entity\Monitoring;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MonitoringControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/monitoring/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Monitoring::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Monitoring index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'monitoring[medicine]' => 'Testing',
            'monitoring[date]' => 'Testing',
            'monitoring[state]' => 'Testing',
            'monitoring[report]' => 'Testing',
            'monitoring[comment]' => 'Testing',
            'monitoring[recommandationVeterinary]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Monitoring();
        $fixture->setMedicine('My Title');
        $fixture->setDate('My Title');
        $fixture->setState('My Title');
        $fixture->setReport('My Title');
        $fixture->setComment('My Title');
        $fixture->setRecommandationVeterinary('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Monitoring');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Monitoring();
        $fixture->setMedicine('Value');
        $fixture->setDate('Value');
        $fixture->setState('Value');
        $fixture->setReport('Value');
        $fixture->setComment('Value');
        $fixture->setRecommandationVeterinary('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'monitoring[medicine]' => 'Something New',
            'monitoring[date]' => 'Something New',
            'monitoring[state]' => 'Something New',
            'monitoring[report]' => 'Something New',
            'monitoring[comment]' => 'Something New',
            'monitoring[recommandationVeterinary]' => 'Something New',
        ]);

        self::assertResponseRedirects('/monitoring/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMedicine());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getState());
        self::assertSame('Something New', $fixture[0]->getReport());
        self::assertSame('Something New', $fixture[0]->getComment());
        self::assertSame('Something New', $fixture[0]->getRecommandationVeterinary());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Monitoring();
        $fixture->setMedicine('Value');
        $fixture->setDate('Value');
        $fixture->setState('Value');
        $fixture->setReport('Value');
        $fixture->setComment('Value');
        $fixture->setRecommandationVeterinary('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/monitoring/');
        self::assertSame(0, $this->repository->count([]));
    }
}

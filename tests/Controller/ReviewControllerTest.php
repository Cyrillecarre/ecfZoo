<?php

namespace App\Test\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReviewControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/review/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Review::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Review index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'review[name]' => 'Testing',
            'review[count]' => 'Testing',
            'review[content]' => 'Testing',
            'review[date]' => 'Testing',
            'review[isApprouved]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Review();
        $fixture->setName('My Title');
        $fixture->setCount('My Title');
        $fixture->setContent('My Title');
        $fixture->setDate('My Title');
        $fixture->setIsApprouved('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Review');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Review();
        $fixture->setName('Value');
        $fixture->setCount('Value');
        $fixture->setContent('Value');
        $fixture->setDate('Value');
        $fixture->setIsApprouved('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'review[name]' => 'Something New',
            'review[count]' => 'Something New',
            'review[content]' => 'Something New',
            'review[date]' => 'Something New',
            'review[isApprouved]' => 'Something New',
        ]);

        self::assertResponseRedirects('/review/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getCount());
        self::assertSame('Something New', $fixture[0]->getContent());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getIsApprouved());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Review();
        $fixture->setName('Value');
        $fixture->setCount('Value');
        $fixture->setContent('Value');
        $fixture->setDate('Value');
        $fixture->setIsApprouved('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/review/');
        self::assertSame(0, $this->repository->count([]));
    }
}

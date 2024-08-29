<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

class ReviewControllerTest extends WebTestCase
{
    private function createReview(EntityManagerInterface $entityManager): Review
    {
        $review = new Review();
        $review->setCount(5);
        $review->setDate(new \DateTime());

        $entityManager->persist($review);
        $entityManager->flush();

        return $review;
    }

    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

    }
    public function testNewReview(): void
{
    $client = static::createClient();
    $crawler = $client->request('GET', '/review/new');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Ajouter un avis');

    $form = $crawler->selectButton('Enregistrer')->form([
        'review[name]' => 'New Review',
        'review[content]' => 'This is a new review content.',
        'review[count]' => 4,
        'review[date]' => (new \DateTime())->format('Y-m-d'),
    ]);

    $client->submit($form);
    $this->assertResponseRedirects('/review/');

    $client->followRedirect();


}
}
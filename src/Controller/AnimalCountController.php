<?php
namespace App\Controller;

use App\Document\AnimalCounter;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;

class AnimalCountController extends AbstractController
{
    private $documentManager;
    private $entityManager;

    public function __construct(DocumentManager $documentManager, EntityManagerInterface $entityManager)
    {
        $this->documentManager = $documentManager;
        $this->entityManager = $entityManager;
    }

    #[Route('/area/{areaId}', name: 'area_show', methods: ['GET'])]
    public function show(int $areaId): Response
    {
        $animals = $this->entityManager->getRepository(Animal::class)->findBy(['area' => $areaId]);

        $animalCounts = [];
        foreach ($animals as $animal) {
            $counter = $this->documentManager->getRepository(AnimalCounter::class)
                ->findOneBy(['animalId' => $animal->getId()]);

            $animalCounts[$animal->getId()] = $counter ? $counter->getCount() : 0;
        }

        return $this->render('area/area3.html.twig', [
            'animals' => $animals,
            'animalCounts' => $animalCounts,
        ]);
    }

    #[Route('/animal/increment/{animalId}', name: 'animal_increment', methods: ['POST'])]
    public function incrementCounter(string $animalId): Response
    {
        $counter = $this->documentManager->getRepository(AnimalCounter::class)
            ->findOneBy(['animalId' => $animalId]);

        if (!$counter) {
            $counter = new AnimalCounter();
            $counter->setAnimalId($animalId);
        }

        $counter->incrementCount();

        $this->documentManager->persist($counter);
        $this->documentManager->flush();

        return $this->json(['success' => true, 'count' => $counter->getCount()]);
    }
}
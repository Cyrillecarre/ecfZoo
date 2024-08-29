<?php

namespace App\Controller;

use App\Entity\Area;
use App\Form\AreaType;
use App\Repository\AreaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Psr\Log\LoggerInterface;
use App\Entity\PictureArea;
use App\Repository\AnimalRepository;
use App\Repository\MonitoringRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PictureAnimalRepository;
use App\Entity\PictureAnimal;
use App\Repository\RecommandationVeterinaryRepository;
use App\Service\RecommandationVeterinary;


#[Route('/area')]
class AreaController extends AbstractController
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/', name: 'app_area_index', methods: ['GET'])]
    public function index(AreaRepository $areaRepository): Response
    {
        return $this->render('area/index.html.twig', [
            'area' => $areaRepository->findAll(),
        ]);
    }

    #[Route('/area1', name: 'area1')]
    public function area1(EntityManagerInterface $entityManager): Response
    {
        $area = $entityManager->getRepository(Area::class)->findOneBy(['name' => 'Tropical']);

        if (!$area) {
            throw $this->createNotFoundException('No area found for name Tropical');
        }

        return $this->render('area/area1.html.twig', [
            'area' => $area,
            'pictures' => $area->getImages(),
            'animals' => $area->getAnimals(),
        ]);
    }

    #[Route('/area2', name: 'area2')]
    public function area2(EntityManagerInterface $entityManager): Response
    {
        $area = $entityManager->getRepository(Area::class)->findOneBy(['name' => 'Savane']);

        if (!$area) {
            throw $this->createNotFoundException('No area found for name Savane');
        }

        return $this->render('area/area2.html.twig', [
            'area' => $area,
            'pictures' => $area->getImages(),
            'animals' => $area->getAnimals(),
        ]);
    }

    #[Route('/area3', name: 'area3')]
    public function area3(EntityManagerInterface $entityManager): Response
    {
        $area = $entityManager->getRepository(Area::class)->findOneBy(['name' => 'Desert']);

        if (!$area) {
            throw $this->createNotFoundException('No area found for name Desert');
        }

        return $this->render('area/area3.html.twig', [
            'area' => $area,
            'pictures' => $area->getImages(),
            'animals' => $area->getAnimals(),
        ]);
    }

    #[Route('/new', name: 'app_area_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $area = new Area();
        $form = $this->createForm(AreaType::class, $area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile[]|null $files */
            $files = $form->get('images')->getData();
            $existingImages = $form->get('existingImages')->getData();
    
            if ($files) {
                foreach ($files as $file) {
                    $imageName = uniqid() . '.' . $file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $imageName
                        );
                        $image = new PictureArea();
                        $image->setPath($imageName);
                        $area->addImage($image);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Failed to upload file: ' . $e->getMessage());
                    }
                }
            }
    
            $entityManager->persist($area);
            $entityManager->flush();
    
            return $this->redirectToRoute('admin_area');
        }

        return $this->render('area/new.html.twig', [
            'area' => $area,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_area_show', methods: ['GET'])]
    public function show(Area $area): Response
    {
        return $this->render('area/show.html.twig', [
            'area' => $area,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_area_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Area $area, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AreaType::class, $area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_area_index');
        }

        return $this->render('area/edit.html.twig', [
            'area' => $area,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_area_delete', methods: ['POST'])]
    public function delete(Request $request, Area $area, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$area->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($area);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_area_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/animal-details/{id}', name: 'animal_details', methods: ['GET'])]
    public function getAnimalDetails(int $id, PictureAnimalRepository $pictureAnimalRepository, MonitoringRepository $monitoringRepository, AnimalRepository $animalRepository, RecommandationVeterinaryRepository $recommandationVeterinaryRepository): JsonResponse
    {
    $pictureAnimal = $pictureAnimalRepository->find($id);

    if (!$pictureAnimal) {
        return new JsonResponse(['error' => 'Image not found'], 404);
    }

    $animal = $pictureAnimal->getAnimal();

    if (!$animal) {
        return new JsonResponse(['error' => 'Animal not found'], 404);
    }

    $recommandationVeterinary = $recommandationVeterinaryRepository->findOneBy(['Animal' => $animal], ['date' => 'DESC']);

    $foods = $recommandationVeterinary ? $recommandationVeterinary->getFoods() : [];

    $foodDetails = [];
    foreach ($foods as $food) {
    $foodDetails[] = [
        'name' => $food->getName(),
        'quantity' => $food->getQuantity(),
    ];
}

    $data = [
        'name' => $animal->getName(),
        'picture' => $animal->getPictureAnimals()->first() ? '/uploads/' . $animal->getPictureAnimals()->first()->getFileName() : null,
        'state' => $recommandationVeterinary ? $recommandationVeterinary->getState() : 'Unknown',
        'foods' => $foodDetails ?: ['No food information available'],
    ];

    return new JsonResponse($data);

    }
}





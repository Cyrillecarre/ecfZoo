<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use App\Entity\Veterinary;
use App\Form\VeterinaryType;
use App\Repository\VeterinaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Area;
use App\Form\AreaType;
use App\Repository\AreaRepository;
use App\Entity\PictureArea;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\AnimalRepository;
use App\Entity\Animal;
use App\Form\AnimalType;
use App\Entity\PictureAnimal;
use App\Repository\ServiceRepository;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ReviewRepository;
use App\Entity\Review;
use App\Repository\MonitoringRepository;
use App\Repository\RecommandationVeterinaryRepository;



class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/employees', name: 'admin_employees')]
    public function employees(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, EmployeRepository $employeRepository): Response
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employe->setPassword(
                $userPasswordHasher->hashPassword(
                    $employe,
                    $form->get('password')->getData()
                )
            );
            $employe->setRoles(['ROLE_EMPLOYE']);
            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('admin_employees', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/employees.html.twig', [
            'form' => $form->createView(),
            'employes' => $employeRepository->findAll(),
        ]);
    }

    #[Route('/admin/employees/{id}/edit', name: 'admin_employe_edit')]
    public function edit(Request $request, Employe $employe, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $employe->setPassword(
                    $userPasswordHasher->hashPassword(
                        $employe,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_employees', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employe/edit.html.twig', [
            'form' => $form->createView(),
            'employe' => $employe,
        ]);
    }

    #[Route('/admin/employees/{id}', name: 'admin_employe_delete', methods: ['POST'])]
    public function delete(Request $request, Employe $employe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($employe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_employees', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/veterinaries', name: 'admin_veterinaries')]
    public function veterinaryList(VeterinaryRepository $veterinaryRepository): Response
    {
    $veterinaries = $veterinaryRepository->findAll();
    
    return $this->render('admin/veterinary.html.twig', [
        'veterinaries' => $veterinaries,
        'form' => $this->createForm(VeterinaryType::class)->createView()
    ]);
    }

    #[Route('/admin/veterinary/new', name: 'admin_veterinary_new', methods: ['GET', 'POST'])]
    public function addVeterinary(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, VeterinaryRepository $veterinaryRepository): Response
    {
        $veterinary = new Veterinary();
        $form = $this->createForm(VeterinaryType::class, $veterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veterinary->setPassword(
                $userPasswordHasher->hashPassword(
                    $veterinary,
                    $form->get('password')->getData()
                )
            );
            $veterinary->setRoles(['ROLE_VETERINARY']);
            $entityManager->persist($veterinary);
            $entityManager->flush();

            return $this->redirectToRoute('admin_veterinaries', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/new.html.twig', [
            'veterinary' => $veterinaryRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/veterinary/{id}/edit', name: 'admin_veterinary_edit')]
    public function editVeterinary(Request $request, Veterinary $veterinary, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(VeterinaryType::class, $veterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $veterinary->setPassword(
                    $userPasswordHasher->hashPassword(
                        $veterinary,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_veterinaries', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/edit.html.twig', [
            'form' => $form->createView(),
            'veterinary' => $veterinary,
        ]);
    }

    #[Route('/admin/veterinary/{id}', name: 'admin_veterinary_delete', methods: ['POST'])]
    public function deleteVeterinary(Request $request, Veterinary $veterinary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinary->getId(), $request->request->get('_token'))) {
            $entityManager->remove($veterinary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_veterinaries', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/area', name: 'admin_area', methods: ['GET'])]
    public function indexArea(AreaRepository $areaRepository): Response
    {
        return $this->render('admin/habitat.html.twig', [
            'areas' => $areaRepository->findAll(),
        ]);
    }

    #[Route('admin/area/{id}/edit', name: 'admin_area_edit', methods: ['GET', 'POST'])]
    public function editArea(Request $request, Area $area, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AreaType::class, $area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile[]|null $files */
            $files = $form->get('images')->getData();

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
                    $image->setArea($area);
                    $area->addImage($image);
                    $entityManager->persist($image);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload file: ' . $e->getMessage());
                }
            }
        }

        foreach ($area->getImages() as $image) {
            $remove = $request->get('remove_image_' . $image->getId());

            if ($remove) {
                $area->removeImage($image);
                $entityManager->remove($image);
            } else {
                $newFile = $request->files->get('replace_image_' . $image->getId());
                if ($newFile) {
                    $newImageName = uniqid() . '.' . $newFile->guessExtension();
                    try {
                        $newFile->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $newImageName
                        );
                        $image->setPath($newImageName);
                        $entityManager->persist($image);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Failed to upload file: ' . $e->getMessage());
                    }
                }
            }
        }

        $entityManager->persist($area);
        $entityManager->flush();


        return $this->redirectToRoute('admin_area', [], Response::HTTP_SEE_OTHER);
    }
        return $this->render('admin/editHabitat.html.twig', [
            'area' => $area,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/animaux', name: 'admin_animaux', methods: ['GET'])]
    public function indexAnimaux(AnimalRepository $animalRepository, AreaRepository $areaRepository): Response
    {
        $areas = $areaRepository->findAll();
    
        return $this->render('admin/animaux.html.twig', [
            'animals' => $animalRepository->findAll(),
            'areas' => $areas,
        ]);
    }

    #[Route('/new', name: 'app_adminAnimal_new', methods: ['GET', 'POST'])]
    public function newAnimal(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile[] $images */
        $images = $form->get('images')->getData();

        foreach ($images as $image) {
            $newFilename = uniqid() . '.' . $image->guessExtension();

            try {
                $image->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/',
                    $newFilename
                );
            } catch (FileException $e) {

            }

            $pictureAnimal = new PictureAnimal();
            $pictureAnimal->setFileName($newFilename);
            $pictureAnimal->setAnimal($animal);

            $animal->addPictureAnimal($pictureAnimal);

            $entityManager->persist($pictureAnimal);
        }

        $entityManager->persist($animal);
        $entityManager->flush();

        return $this->redirectToRoute('admin_animaux', [], Response::HTTP_SEE_OTHER);
    }
        return $this->render('admin/animalNew.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_adminAnimal_edit', methods: ['GET', 'POST'])]
    public function editAnimal(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile[] $images */
            $images = $form->get('images')->getData();
    
            if ($images) {
                foreach ($animal->getPictureAnimals() as $existingPicture) {
                    $entityManager->remove($existingPicture);
                    unlink($this->getParameter('kernel.project_dir') . '/public/uploads/' . $existingPicture->getFileName());
                }
                $animal->getPictureAnimals()->clear();
    
                foreach ($images as $image) {
                    $newFilename = uniqid() . '.' . $image->guessExtension();
    
                    try {
                        $image->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $newFilename
                        );
                    } catch (FileException $e) {

                    }
    
                    $pictureAnimal = new PictureAnimal();
                    $pictureAnimal->setFileName($newFilename);
                    $pictureAnimal->setAnimal($animal);
    
                    $animal->addPictureAnimal($pictureAnimal);
                    $entityManager->persist($pictureAnimal);
                }
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('admin_animaux', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/animalNew.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/admin/animal/delete/{id}', name: 'app_adminAnimal_delete', methods: ['POST'])]
    public function deleteAnimal(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/service', name: 'admin_service', methods: ['GET'])]
    public function indexService(ServiceRepository $serviceRepository): Response
    {
        return $this->render('admin/service.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_adminService_edit', methods: ['GET', 'POST'])]
    public function editService(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        $oldFilename = $service->getPicture();

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('picture')->getData();

        if ($imageFile) {
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $newFilename
                );

                $service->setPicture('/uploads/' . $newFilename);

                if ($oldFilename && file_exists($this->getParameter('kernel.project_dir') . '/public' . $oldFilename)) {
                    unlink($this->getParameter('kernel.project_dir') . '/public' . $oldFilename);
                }
            } catch (FileException $e) {

            }
        } else {
            $service->setPicture($oldFilename);
        }
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/service.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/admin_review', name: 'admin_review', methods: ['GET'])]
    public function indexReview(ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findAll();
        $totalReviews = count($reviews);

        $sum = array_reduce($reviews, fn($carry, $item) => $carry + $item->getCount(), 0);
        $averageRating = $totalReviews > 0 ? $sum / $totalReviews : 0;

        return $this->render('admin/review.html.twig', [
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
        ]);
    }

    #[Route('/{id}/approve', name: 'app_review_approve', methods: ['GET'])]
    public function approve(Review $review, EntityManagerInterface $entityManager): Response
    {

    $review->setApprouved(true);
    $entityManager->flush();

    return $this->redirectToRoute('admin_review');
    }

    #[Route('/{id}/delete', name: 'app_adminReview_delete', methods: ['GET'])]
    public function deleteReview(Review $review, EntityManagerInterface $entityManager): Response
    {
    $entityManager->remove($review);
    $entityManager->flush();

    return $this->redirectToRoute('admin_review');
    }

    #[Route('/dashboard', name: 'app_adminDashboard', methods: ['GET'])]
    public function dashboard(MonitoringRepository $monitoringRepository, AnimalRepository $animalRepository): Response
    {

        $animalStats = [
            'Bonne santé' => $monitoringRepository->count(['state' => 'Bonne santé']),
            'Malade' => $monitoringRepository->count(['state' => 'Malade']),
            'En convalescence' => $monitoringRepository->count(['state' => 'En convalescence']),
            'Blessé' => $monitoringRepository->count(['state' => 'Blessé']),
        ];
    
        $animalsTropical = $animalRepository->createQueryBuilder('a')
            ->innerJoin('a.area', 'ar')
            ->where('ar.name = :zone')
            ->setParameter('zone', 'Tropical')
            ->getQuery()
            ->getResult();
    
        $animalTropical = [
            'Bonne santé' => 0,
            'Malade' => 0,
            'En convalescence' => 0,
            'Blessé' => 0,
        ];
    
        foreach ($animalsTropical as $animal) {
            $latestMonitoring = $monitoringRepository->findOneBy(['animal' => $animal], ['date' => 'DESC']);
            if ($latestMonitoring) {
                $state = $latestMonitoring->getState();
                if (isset($animalTropical[$state])) {
                    $animalTropical[$state]++;
                }
            }
        }

        $animalsSavane = $animalRepository->createQueryBuilder('a')
            ->innerJoin('a.area', 'ar')
            ->where('ar.name = :zone')
            ->setParameter('zone', 'Savane')
            ->getQuery()
            ->getResult();
    
        $animalSavane = [
            'Bonne santé' => 0,
            'Malade' => 0,
            'En convalescence' => 0,
            'Blessé' => 0,
        ];
    
        foreach ($animalsSavane as $animal) {
            $latestMonitoring = $monitoringRepository->findOneBy(['animal' => $animal], ['date' => 'DESC']);
            if ($latestMonitoring) {
                $state = $latestMonitoring->getState();
                if (isset($animalSavane[$state])) {
                    $animalSavane[$state]++;
                }
            }
        }

        $animalsDesert = $animalRepository->createQueryBuilder('a')
            ->innerJoin('a.area', 'ar')
            ->where('ar.name = :zone')
            ->setParameter('zone', 'Desert')
            ->getQuery()
            ->getResult();
    
        $animalDesert = [
            'Bonne santé' => 0,
            'Malade' => 0,
            'En convalescence' => 0,
            'Blessé' => 0,
        ];
    
        foreach ($animalsDesert as $animal) {
            $latestMonitoring = $monitoringRepository->findOneBy(['animal' => $animal], ['date' => 'DESC']);
            if ($latestMonitoring) {
                $state = $latestMonitoring->getState();
                if (isset($animalDesert[$state])) {
                    $animalDesert[$state]++;
                }
            }
        }

    return $this->render('admin/dashboard.html.twig', [
        'animalStats' => $animalStats,
        'animalTropical' => $animalTropical,
        'animalSavane' => $animalSavane,
        'animalDesert' => $animalDesert,
    ]);
    }

    #[Route('/admin/pointsante', name: 'app_admin_point_sante', methods: ['GET'])]
    public function veterinaryPointSante(AnimalRepository $animalRepository, RecommandationVeterinaryRepository $recommandationVeterinaryRepository, MonitoringRepository $monitoringRepository): Response {
        $animals = $animalRepository->findAll();

        $data = [];

        foreach ($animals as $animal) {
            $recommandationVeterinary = $recommandationVeterinaryRepository->findOneBy(['Animal' => $animal], ['date' => 'DESC']);
            $monitoring = $monitoringRepository->findOneBy(['animal' => $animal], ['date' => 'DESC']);

            $data[] = [
                'animal' => $animal,
                'recommandationVeterinary' => $recommandationVeterinary,
                'monitoring' => $monitoring
            ];
        }

        return $this->render('admin/pointSante.html.twig', [
            'data' => $data,
        ]);
    }
}

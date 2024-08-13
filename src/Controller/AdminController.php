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
                    $area->addImage($image);
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
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/animalNew.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adminAnimal_delete', methods: ['POST'])]
    public function deleteAnimal(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}

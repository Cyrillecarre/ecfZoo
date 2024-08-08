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
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


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
    public function veterinaryList(Request $request, EntityManagerInterface $entityManager, VeterinaryRepository $veterinaryRepository): Response
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
}

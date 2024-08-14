<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('picture')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFilename
                    );
                } catch (FileException $e) {

            }

            $service->setPicture('/uploads/' . $newFilename);
        }

            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager): Response
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

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}

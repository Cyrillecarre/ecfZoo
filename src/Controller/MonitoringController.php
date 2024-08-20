<?php

namespace App\Controller;

use App\Entity\Monitoring;
use App\Form\MonitoringType;
use App\Repository\MonitoringRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/monitoring')]
class MonitoringController extends AbstractController
{
    #[Route('/', name: 'app_monitoring_index', methods: ['GET'])]
    public function index(MonitoringRepository $monitoringRepository): Response
    {
        return $this->render('monitoring/index.html.twig', [
            'monitorings' => $monitoringRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_monitoring_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $monitoring = new Monitoring();
        $form = $this->createForm(MonitoringType::class, $monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($monitoring);
            $entityManager->flush();

            return $this->redirectToRoute('app_monitoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monitoring/new.html.twig', [
            'monitoring' => $monitoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monitoring_show', methods: ['GET'])]
    public function show(Monitoring $monitoring): Response
    {
        return $this->render('monitoring/show.html.twig', [
            'monitoring' => $monitoring,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_monitoring_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Monitoring $monitoring, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MonitoringType::class, $monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_monitoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monitoring/edit.html.twig', [
            'monitoring' => $monitoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monitoring_delete', methods: ['POST'])]
    public function delete(Request $request, Monitoring $monitoring, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monitoring->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($monitoring);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_monitoring_index', [], Response::HTTP_SEE_OTHER);
    }
}

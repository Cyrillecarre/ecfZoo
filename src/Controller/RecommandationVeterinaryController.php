<?php

namespace App\Controller;

use App\Entity\RecommandationVeterinary;
use App\Form\RecommandationVeterinaryType;
use App\Repository\RecommandationVeterinaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recommandation/veterinary')]
class RecommandationVeterinaryController extends AbstractController
{
    #[Route('/', name: 'app_recommandation_veterinary_index', methods: ['GET'])]
    public function index(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        return $this->render('recommandation_veterinary/index.html.twig', [
            'recommandation_veterinaries' => $recommandationVeterinaryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recommandation_veterinary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recommandationVeterinary = new RecommandationVeterinary();
        $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recommandationVeterinary);
            $entityManager->flush();

            return $this->redirectToRoute('app_recommandation_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recommandation_veterinary/new.html.twig', [
            'recommandation_veterinary' => $recommandationVeterinary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recommandation_veterinary_show', methods: ['GET'])]
    public function show(RecommandationVeterinary $recommandationVeterinary): Response
    {
        return $this->render('recommandation_veterinary/show.html.twig', [
            'recommandation_veterinary' => $recommandationVeterinary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recommandation_veterinary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecommandationVeterinary $recommandationVeterinary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recommandation_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recommandation_veterinary/edit.html.twig', [
            'recommandation_veterinary' => $recommandationVeterinary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recommandation_veterinary_delete', methods: ['POST'])]
    public function delete(Request $request, RecommandationVeterinary $recommandationVeterinary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recommandationVeterinary->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($recommandationVeterinary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recommandation_veterinary_index', [], Response::HTTP_SEE_OTHER);
    }
}

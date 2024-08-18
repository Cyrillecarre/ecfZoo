<?php

namespace App\Controller;

use App\Entity\Veterinary;
use App\Entity\RecommandationVeterinary;
use App\Repository\RecommandationVeterinaryRepository;
use App\Form\RecommandationVeterinaryType;
use App\Form\VeterinaryType;
use App\Repository\VeterinaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;







#[Route('/veterinary')]
class VeterinaryController extends AbstractController
{
    #[Route('/', name: 'app_veterinary_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('veterinary/index.html.twig', [
            'controller_name' => 'VeterinaryController',
        ]);
    }

    #[Route('/new', name: 'app_veterinary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
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

            return $this->redirectToRoute('app_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/new.html.twig', [
            'veterinary' => $veterinary,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_veterinary_show', methods: ['GET'])]
    public function show(Veterinary $veterinary): Response
    {
        return $this->render('veterinary/show.html.twig', [
            'veterinary' => $veterinary,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_veterinary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Veterinary $veterinary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinaryType::class, $veterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/edit.html.twig', [
            'veterinary' => $veterinary,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_veterinary_delete', methods: ['POST'])]
    public function delete(Request $request, Veterinary $veterinary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinary->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($veterinary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_veterinary_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/recommandation', name: 'app_veterinaryRecommandation_veterinary_index', methods: ['GET'])]
    public function indexRecommandation(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        return $this->render('veterinary/recommandation.html.twig', [
            'recommandation_veterinaries' => $recommandationVeterinaryRepository->findAll(),
        ]);
    }

    #[Route('/recommandation/new', name: 'app_veterinaryRecommandation_veterinary_new', methods: ['GET', 'POST'])]
    public function newRecommandation(Request $request, EntityManagerInterface $entityManager, RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationVeterinary = new RecommandationVeterinary();
    $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $existingRecommandation = $recommandationVeterinaryRepository->findOneBy(['Animal' => $recommandationVeterinary->getAnimal()]);
        
        if ($existingRecommandation) {
            $this->addFlash('error', 'Cet animal a déjà une recommandation.');
            return $this->redirectToRoute('app_veterinaryRecommandation_veterinary_index');
        }

        $entityManager->persist($recommandationVeterinary);
        foreach ($recommandationVeterinary->getFoods() as $food) {
            if (null === $food->getId()) {
                $entityManager->persist($food);
            }
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_veterinaryRecommandation_veterinary_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('veterinary/recommandation_new.html.twig', [
        'recommandation_veterinary' => $recommandationVeterinary,
        'form' => $form->createView(),
        'recommandation_veterinaries' => $recommandationVeterinaryRepository->findAll(),
    ]);
    }
    #[Route('/recommandation/edit/{id}', name: 'app_veterinaryRecommandation_veterinary_edit', methods: ['GET', 'POST'])]
    public function editRecommandation(Request $request, RecommandationVeterinary $recommandationVeterinary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaryRecommandation_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/recommandation.html.twig', [
            'recommandation_veterinary' => $recommandationVeterinary,
            'form' => $form,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\RecommandationVeterinaryRepository;
use App\Repository\AnimalRepository;
use App\Entity\Monitoring;
use App\Form\MonitoringType;


#[Route('/employe')]
class EmployeController extends AbstractController
{
    #[Route('/', name: 'app_employe_index', methods: ['GET'])]
    public function index(EmployeRepository $employeRepository): Response
    {
        return $this->render('employe/index.html.twig', [
            'employes' => $employeRepository->findAll(),
        ]);
    }

    #[Route('/tropical', name: 'app_employeTropical_index', methods: ['GET'])]
    public function indexTropical(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationsTropical = array_filter(
            $recommandationVeterinaryRepository->findAll(),
            fn($recommandation) => $recommandation->getAnimal()->getArea()->getName() === 'Tropical'
        );

    return $this->render('employe/tropical.html.twig', [
        'recommandation_veterinaries' => $recommandationsTropical,
    ]);
    }

    #[Route('/savane', name: 'app_employeSavane_index', methods: ['GET'])]
    public function indexSavane(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationsSavane = $recommandationVeterinaryRepository->createQueryBuilder('r')
        ->join('r.Animal', 'a')
        ->join('a.area', 'ar')
        ->where('ar.name = :zone')
        ->setParameter('zone', 'Savane')
        ->getQuery()
        ->getResult();

    return $this->render('employe/savane.html.twig', [
        'recommandation_veterinaries' => $recommandationsSavane,
    ]);
    }

    #[Route('/desert', name: 'app_employeDesert_index', methods: ['GET'])]
    public function indexDesert(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationsDesert = array_filter(
            $recommandationVeterinaryRepository->findAll(),
            fn($recommandation) => $recommandation->getAnimal()->getArea()->getName() === 'Desert'
        );
        return $this->render('employe/desert.html.twig', [
            'recommandation_veterinaries' => $recommandationsDesert,
        ]);
    }

    #[Route('/monitoring/new/{animalId}', name: 'app_employeMonitoring_new', methods: ['GET', 'POST'])]
public function newMonitoring(Request $request, EntityManagerInterface $entityManager, AnimalRepository $animalRepository, RecommandationVeterinaryRepository $recommandationVeterinaryRepository, $animalId): Response
{
    $monitoring = new Monitoring();
    $animal = $animalRepository->find($animalId);

    if (!$animal) {
        throw $this->createNotFoundException('Animal not found');
    }

    $recommandationVeterinary = $recommandationVeterinaryRepository->findOneBy(['Animal' => $animal]);

    $monitoring->setAnimal($animal);
    $form = $this->createForm(MonitoringType::class, $monitoring);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($monitoring);
        $entityManager->flush();

        return $this->redirectToRoute('app_employe_index');
    }

    return $this->render('employe/monitoringNew.html.twig', [
        'monitoring' => $monitoring,
        'form' => $form->createView(),
        'recommandation_veterinary' => $recommandationVeterinary,
    ]);
}




    #[Route('/new', name: 'app_employe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
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

            return $this->redirectToRoute('app_employe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employe/new.html.twig', [
            'employe' => $employe,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_employe_show', methods: ['GET'])]
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employe $employe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_employe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employe/edit.html.twig', [
            'employe' => $employe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employe_delete', methods: ['POST'])]
    public function delete(Request $request, Employe $employe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($employe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_employe_index', [], Response::HTTP_SEE_OTHER);
    }
}

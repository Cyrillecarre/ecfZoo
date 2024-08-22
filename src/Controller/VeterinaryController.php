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
use App\Repository\AnimalRepository;
use App\Repository\MonitoringRepository;







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

    #[Route('/tropical', name: 'app_veterinaryTropical_index', methods: ['GET'])]
    public function indexTropical(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $subQuery = $recommandationVeterinaryRepository->createQueryBuilder('r2')
        ->select('MAX(r2.id)')
        ->innerJoin('r2.Animal', 'a2')
        ->where('a2.area = ar')
        ->groupBy('a2.id')
        ->getDQL();

    $query = $recommandationVeterinaryRepository->createQueryBuilder('r')
        ->innerJoin('r.Animal', 'a')
        ->innerJoin('a.area', 'ar')
        ->where('ar.name = :zone')
        ->andWhere('r.id IN (' . $subQuery . ')')
        ->setParameter('zone', 'Tropical')
        ->getQuery();

    $recommandationsTropical = $query->getResult();
    return $this->render('veterinary/tropical.html.twig', [
        'recommandation_veterinaries' => $recommandationsTropical,
    ]);
    }

    #[Route('/savane', name: 'app_veterinarySavane_index', methods: ['GET'])]
    public function indexSavane(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $subQuery = $recommandationVeterinaryRepository->createQueryBuilder('r2')
        ->select('MAX(r2.id)')
        ->innerJoin('r2.Animal', 'a2')
        ->innerJoin('a2.area', 'ar2')
        ->where('ar2.name = :zone')
        ->groupBy('a2.id')
        ->getDQL();

        $query = $recommandationVeterinaryRepository->createQueryBuilder('r')
        ->innerJoin('r.Animal', 'a')
        ->where('r.id IN (' . $subQuery . ')')
        ->setParameter('zone', 'Savane')
        ->getQuery();

        $recommandationsSavane = $query->getResult();

    return $this->render('veterinary/savane.html.twig', [
        'recommandation_veterinaries' => $recommandationsSavane,
    ]);
    }

    #[Route('/tropical/new', name: 'app_veterinaryTropical_new', methods: ['GET', 'POST'])]
    public function newTropical(Request $request, EntityManagerInterface $entityManager, RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationVeterinary = new RecommandationVeterinary();
        $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary, [
            'zone' => 'Tropical'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recommandationVeterinary);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaryTropical_index');
        }

        return $this->render('veterinary/recommandation_new.html.twig', [
        'recommandation_veterinary' => $recommandationVeterinary,
        'form' => $form->createView(),
    ]);
    }

    #[Route('/savane/new', name: 'app_veterinarySavane_new', methods: ['GET', 'POST'])]
    public function newSavane(Request $request, EntityManagerInterface $entityManager, RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationVeterinary = new RecommandationVeterinary();
        $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary, [
            'zone' => 'Savane'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recommandationVeterinary);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinarySavane_index');
        }

    return $this->render('veterinary/recommandation_new.html.twig', [
        'recommandation_veterinary' => $recommandationVeterinary,
        'form' => $form->createView(),
    ]);
    }

    #[Route('/desert/new', name: 'app_veterinaryDesert_new', methods: ['GET', 'POST'])]
    public function newDesert(Request $request, EntityManagerInterface $entityManager, RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandationVeterinary = new RecommandationVeterinary();
        $form = $this->createForm(RecommandationVeterinaryType::class, $recommandationVeterinary, [
            'zone' => 'Desert'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recommandationVeterinary);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinaryDesert_index');
        }

    return $this->render('veterinary/recommandation_new.html.twig', [
        'recommandation_veterinary' => $recommandationVeterinary,
        'form' => $form->createView(),
    ]);
    }


    #[Route('/desert', name: 'app_veterinaryDesert_index', methods: ['GET'])]
    public function indexDesert(RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $subQuery = $recommandationVeterinaryRepository->createQueryBuilder('r2')
        ->select('MAX(r2.id)')
        ->innerJoin('r2.Animal', 'a2')
        ->innerJoin('a2.area', 'ar2')
        ->where('ar2.name = :zone')
        ->groupBy('a2.id')
        ->getDQL();


        $query = $recommandationVeterinaryRepository->createQueryBuilder('r')
        ->innerJoin('r.Animal', 'a')
        ->where('r.id IN (' . $subQuery . ')')
        ->setParameter('zone', 'Desert')
        ->getQuery();

        $recommandationsDesert = $query->getResult();
        return $this->render('veterinary/desert.html.twig', [
            'recommandation_veterinaries' => $recommandationsDesert,
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
    #[Route('/animal/{id}/recommandations', name: 'app_animal_recommandations', methods: ['GET'])]
    public function showRecommandationsForAnimal(int $id, RecommandationVeterinaryRepository $recommandationVeterinaryRepository): Response
    {
        $recommandations = $recommandationVeterinaryRepository->findBy(
            ['Animal' => $id],
            ['date' => 'DESC']
        );

        $zone = $recommandations[0]->getAnimal()->getArea()->getName();

        return $this->render('veterinary/animal_recommandations.html.twig', [
            'recommandations' => $recommandations,
            'zone' => $zone,
        ]);
    }

    #[Route('/veterinaire/pointsante', name: 'app_veterinary_point_sante', methods: ['GET'])]
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

        return $this->render('veterinary/pointSante.html.twig', [
            'data' => $data,
        ]);
    }

}

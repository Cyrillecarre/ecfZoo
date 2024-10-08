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
use App\Repository\MonitoringRepository;
use App\Document\AnimalCounter;
use Doctrine\ODM\MongoDB\DocumentManager;


#[Route('/employe')]
class EmployeController extends AbstractController
{
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

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
    return $this->render('employe/tropical.html.twig', [
        'recommandation_veterinaries' => $recommandationsTropical,
    ]);
    }

    #[Route('/savane', name: 'app_employeSavane_index', methods: ['GET'])]
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
    return $this->render('employe/savane.html.twig', [
        'recommandation_veterinaries' => $recommandationsSavane,
    ]);
    }

    #[Route('/desert', name: 'app_employeDesert_index', methods: ['GET'])]
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
        return $this->render('employe/desert.html.twig', [
            'recommandation_veterinaries' => $recommandationsDesert,
        ]);
    }

    #[Route('/monitoring/new/{animalId}', name: 'app_employeMonitoring_new', methods: ['GET', 'POST'])]
    public function newMonitoring(Request $request, EntityManagerInterface $entityManager, AnimalRepository $animalRepository, RecommandationVeterinaryRepository $recommandationVeterinaryRepository, $animalId, MonitoringRepository $monitoringRepository): Response
    {
        $animal = $animalRepository->find($animalId);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé');
        }
    
        $recommandationVeterinary = $recommandationVeterinaryRepository->createQueryBuilder('r')
            ->where('r.Animal = :animal')
            ->setParameter('animal', $animal)
            ->orderBy('r.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    
        if (!$recommandationVeterinary) {
            throw $this->createNotFoundException('Recommandation vétérinaire non trouvée pour cet animal');
        }

        $existingMonitoring = $monitoringRepository->createQueryBuilder('m')
        ->where('m.recommandationVeterinary = :recommandationVeterinary')
        ->andWhere('m.date >= :date')
        ->setParameter('recommandationVeterinary', $recommandationVeterinary)
        ->setParameter('date', $recommandationVeterinary->getDate())
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

    if ($existingMonitoring) {
        return $this->render('employe/monitoringExist.html.twig', [
            'monitoring' => $existingMonitoring,
            'animal' => $animal,
        ]);
    } else {
        // Si aucun monitoring récent n'existe, créer un nouveau
        $monitoring = new Monitoring();
        $monitoring->setAnimal($animal);
        $monitoring->setRecommandationVeterinary($recommandationVeterinary);

        $form = $this->createForm(MonitoringType::class, $monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($monitoring);
            $entityManager->flush();

            return $this->redirectToRoute('app_point_sante');
        }

        return $this->render('employe/monitoringNew.html.twig', [
            'monitoring' => $monitoring,
            'form' => $form->createView(),
            'recommandation_veterinary' => $recommandationVeterinary,
        ]);
        }
    }

    #[Route('/{id}/edit', name: 'app_employeMonitoring_edit', methods: ['GET', 'POST'])]
    public function editMonitoring(Request $request, Monitoring $monitoring, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MonitoringType::class, $monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_point_sante', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employe/monitoringEdit.html.twig', [
            'monitoring' => $monitoring,
            'form' => $form,
        ]);
    }

    #[Route('/animal/{id}/details', name: 'app_animal_details', methods: ['GET'])]
    public function animalDetails(int $id, AnimalRepository $animalRepository, RecommandationVeterinaryRepository $recommandationVeterinaryRepository, MonitoringRepository $monitoringRepository): Response
    {
        $animal = $animalRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }

        $recommandationsVeterinary = $recommandationVeterinaryRepository->findBy(['Animal' => $animal], ['date' => 'DESC']);
        $monitorings = $monitoringRepository->findBy(['animal' => $animal], ['date' => 'DESC']);

        return $this->render('employe/animalDetail.html.twig', [
            'animal' => $animal,
            'recommandationsVeterinary' => $recommandationsVeterinary,
            'monitorings' => $monitorings,
        ]);
}


    #[Route('/pointsante', name: 'app_point_sante', methods: ['GET'])]
    public function pointSante(AnimalRepository $animalRepository, RecommandationVeterinaryRepository $recommandationVeterinaryRepository, MonitoringRepository $monitoringRepository): Response {
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

        return $this->render('employe/pointSante.html.twig', [
            'data' => $data,
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

    #[Route('/employe/{id<\d+>}', name: 'app_employe_show', methods: ['GET'])]
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

    #[Route('/dashboard', name: 'app_employeDashboard', methods: ['GET'])]
    public function dashboard(MonitoringRepository $monitoringRepository, AnimalRepository $animalRepository, DocumentManager $documentManager): Response
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
        $animalCounters = $this->documentManager->getRepository(AnimalCounter::class)->findAll();
    
        $animalPopularity = [];
        foreach ($animalCounters as $counter) {
            $animal = $animalRepository->find($counter->getAnimalId());
            if ($animal) {
                $animalPopularity[$animal->getName()] = $counter->getCount();
            }
        }

        $areas = ['Tropical', 'Savane', 'Desert'];
    $popularityByArea = [];

    foreach ($areas as $areaName) {
        $animals = $animalRepository->createQueryBuilder('a')
            ->innerJoin('a.area', 'ar')
            ->where('ar.name = :zone')
            ->setParameter('zone', $areaName)
            ->getQuery()
            ->getResult();

        $popularityByArea[$areaName] = [];

        foreach ($animals as $animal) {
            $counter = $documentManager->getRepository(AnimalCounter::class)
                ->findOneBy(['animalId' => $animal->getId()]);

            $popularityByArea[$areaName][$animal->getName()] = $counter ? $counter->getCount() : 0;
        }
    }

    return $this->render('employe/dashboard.html.twig', [
        'animalStats' => $animalStats,
        'animalTropical' => $animalTropical,
        'animalSavane' => $animalSavane,
        'animalDesert' => $animalDesert,
        'animalPopularity' => $animalPopularity,
        'popularityByArea' => $popularityByArea,
    ]);
    }
}

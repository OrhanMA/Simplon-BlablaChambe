<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ride;
use App\Entity\User;
use App\Entity\Rule;

class TrajetsController extends AbstractController
{
    #[Route('/trajets', name: 'app_trajets')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // J'accède au repertoire de la classe Product grâce au EntityManagerInterface
        $rideRepository = $entityManager->getRepository(Ride::class);
        $userRepository = $entityManager->getRepository(User::class);
        $allRides = $rideRepository->findAll();
        $users = $userRepository->findAll();
        return $this->render('trajets/index.html.twig', [
            'controller_name' => 'TrajetsController',
            'rides' => $allRides,
            'users' => $users,
        ]);
    }
    #[Route('/trajets/detail/{id}', name: 'app_trajets_detail')]
    public function detail(EntityManagerInterface $entityManager, string $id): Response
    {
        // J'accède au repertoire de la classe Product grâce au EntityManagerInterface
        $rideRepository = $entityManager->getRepository(Ride::class);
        $userRepository = $entityManager->getRepository(User::class);
        $ruleRepository = $entityManager->getRepository(Rule::class);
        $ride = $rideRepository->find($id);
        $users = $userRepository->findAll();
        $rules = $ruleRepository->findAll();
        return $this->render('trajets/detail.html.twig', [
            'ride' => $ride,
            'users' => $users,
            'rules' => $rules,
        ]);
    }

}
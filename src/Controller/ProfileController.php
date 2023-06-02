<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Ride;
use App\Entity\User;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();

        // Access the user ID
        $userId = $user->getId();

        $rideRepository = $entityManager->getRepository(Ride::class);
        $userRepository = $entityManager->getRepository(User::class);
        $carRepository = $entityManager->getRepository(Car::class);
        $rides = $rideRepository->findBy(['driver' => $userId]);
        $user = $userRepository->find($userId);
        $cars = $carRepository->findBy(['owner' => $userId]);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'userId' => $userId,
            'rides' => $rides,
            'user' => $user,
            'cars' => $cars,
        ]);
    }



}
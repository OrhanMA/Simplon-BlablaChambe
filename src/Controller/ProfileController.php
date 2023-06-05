<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Ride;
use App\Entity\User;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CarType;
use DateTime;

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
        // Comment out the following line that reassigns $user
        // $user = $userRepository->find($userId);
        $cars = $carRepository->findBy(['owner' => $userId]);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'userId' => $userId,
            'rides' => $rides,
            'user' => $user,
            // Use the original $user object instead
            'cars' => $cars,
        ]);
    }

    #[Route('/profile/edit_user', name: 'app_edit_user')]
    public function editUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Retrieve the authenticated user
        $user = $this->security->getUser();

        // Create the form for editing the user properties
        $form = $this->createFormBuilder($user)
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('email')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the updated user entity
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/edit_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }



    #[Route('/profile/add_car', name: 'app_add_car')]
    public function insert(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser(); // Retrieve the authenticated user

        $car = new Car();
        $car->setOwner($user); // Set the owner of the car entity
        $car->setCreated(new DateTime);
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the car entity
            $entityManager->persist($car);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/add_car.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit_car/{id}', name: 'app_edit_car')]
    public function editCar(Request $request, EntityManagerInterface $entityManager, Car $car): Response
    {
        // Retrieve the authenticated user
        $user = $this->security->getUser();

        // Create the form for editing the car properties
        $form = $this->createFormBuilder($car)
            ->add('brand')
            ->add('model')
            ->add('seats')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the updated car entity
            $entityManager->persist($car);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/edit_car.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'car' => $car,
            'id' => $car->getId(), // Pass the car's ID as a parameter
        ]);
    }

    #[Route('/profile/delete_car/{id}', name: 'app_delete_car')]
    public function deleteCar(EntityManagerInterface $entityManager, Car $car): Response
    {
        // Remove the car entity
        $entityManager->remove($car);
        $entityManager->flush();

        // Redirect the user to a success page or any other desired action
        return $this->redirectToRoute('app_profile');
    }






}
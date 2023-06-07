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
use App\Entity\Rule;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CarType;
use App\Form\RideType;
use App\Form\RuleType;
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
        $ruleRepository = $entityManager->getRepository(Rule::class);
        $userRepository = $entityManager->getRepository(User::class);
        $carRepository = $entityManager->getRepository(Car::class);
        $rides = $rideRepository->findBy(['driver' => $userId]);
        $rules = $ruleRepository->findBy(['author' => $userId]);
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
            'rules' => $rules,
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



    #[Route('/profile/add_ride', name: 'app_add_ride')]
    public function insertRide(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser(); // Retrieve the authenticated user

        $ride = new Ride();
        $ride->setDriver($user); // Set the driver of the ride entity
        $ride->setCreated(new \DateTime());

        $form = $this->createForm(RideType::class, $ride);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the ride entity
            $entityManager->persist($ride);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/add_ride.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit_ride/{id}', name: 'app_edit_ride')]
    public function editRide(Request $request, EntityManagerInterface $entityManager, ride $ride): Response
    {
        // Retrieve the authenticated user
        $user = $this->security->getUser();

        // Create the form for editing the ride properties
        $form = $this->createFormBuilder($ride)
            ->add('departure')
            ->add('destination')
            ->add('seats')
            ->add('price')
            ->add('date')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the updated ride entity
            $entityManager->persist($ride);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/edit_ride.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'ride' => $ride,
            'id' => $ride->getId(), // Pass the ride's ID as a parameter
        ]);
    }



    #[Route('/profile/delete_ride/{id}', name: 'app_delete_ride')]
    public function deleteRide(EntityManagerInterface $entityManager, Ride $ride): Response
    {
        // Remove the car entity
        $entityManager->remove($ride);
        $entityManager->flush();

        // Redirect the user to a success page or any other desired action
        return $this->redirectToRoute('app_profile');
    }

    #[Route('/profile/add_rule', name: 'app_add_rule')]
    public function insertRule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser(); // Retrieve the authenticated user

        $rule = new Rule();
        $rule->setAuthor($user);


        $form = $this->createForm(RuleType::class, $rule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the rule entity
            $entityManager->persist($rule);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/add_rule.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'rules' => $rule,
        ]);
    }

    #[Route('/profile/edit_rule/{id}', name: 'app_edit_rule')]
    public function editRule(Request $request, EntityManagerInterface $entityManager, Rule $rule): Response
    {
        // Retrieve the authenticated user
        $user = $this->security->getUser();

        // Create the form for editing the rule properties
        $form = $this->createFormBuilder($rule)
            ->add('name')
            ->add('description')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form was submitted and the data is valid

            // Persist the updated rule entity
            $entityManager->persist($rule);
            $entityManager->flush();

            // Redirect the user to a success page or any other desired action
            return $this->redirectToRoute('app_profile');
        }

        // Render the form template
        return $this->render('profile/edit_rule.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'rule' => $rule,
            'id' => $rule->getId(), // Pass the rule's ID as a parameter
        ]);
    }

    #[Route('/profile/delete_rule/{id}', name: 'app_delete_rule')]
    public function deleteRule(EntityManagerInterface $entityManager, Rule $rule): Response
    {
        // Remove the rule entity
        $entityManager->remove($rule);
        $entityManager->flush();

        // Redirect the user to a success page or any other desired action
        return $this->redirectToRoute('app_profile');
    }

}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetsController extends AbstractController
{
    #[Route('/trajets', name: 'app_trajets')]
    public function index(): Response
    {
        return $this->render('trajets/index.html.twig', [
            'controller_name' => 'TrajetsController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/medecin', name: 'medecin')]
    public function medecin(): Response
    {
        return $this->render('main/medecin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/patient', name: 'patient')]
    public function patient(): Response
    {
        return $this->render('main/patient.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }
}

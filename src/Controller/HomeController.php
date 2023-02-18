<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        return $this->render('main/homeGuest.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/homePatient', name: 'homePatient')]
    public function homePatient(): Response
    {
        return $this->render('main/homePatient.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/homeMedecin', name: 'homeMedecin')]
    public function homeMedecin(): Response
    {
        return $this->render('main/homeMedecin.html.twig', [
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
    #[Route('/resetPassword/{token}', name: 'resetPassword')]
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);
        dump($token);
        dump($user);
        if ($user === null) {
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('login');
        }
        if ($request->isMethod('POST')) {

            $user->setResetToken("");
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('message', 'Mot de passe mis à jour');
            return $this->redirectToRoute('login');
        } else {
            return $this->render('security/resetPassword.html.twig', ['token' => $token]);
        }


    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }

}

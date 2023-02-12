<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Controller\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/checkLogin', name: 'checkLogin')]
    public function login_check(UserRepository $userRepository ,LoginLinkHandlerInterface $loginLink,MailerInterface $mailer): Response
    {
        $users=$userRepository->findAll();
        foreach ($users as $user)
        {
            $LoginLinkDetails=$loginLink->createLoginLink($user);
            $email=(new \Symfony\Component\Mime\Email())
                ->from('muhamedabesy10@gmail.com')
                ->to($user->getEmail())
                ->subject('Login Check')
                ->text('verify link '.$LoginLinkDetails->getUrl());
            $mailer->send($email);

        }
        return new Response('checkLogin');
    }


}

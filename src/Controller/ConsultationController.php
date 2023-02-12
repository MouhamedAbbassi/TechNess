<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Consultation;
use App\Form\ConsultationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'app_consultation')]
    public function index(): Response
    {
        return $this->render('consultation/reserver.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }


    #[Route('/Add', name: 'add_consultation')]
public function AddFormClassRoomMaker(Request $request , EntityManagerInterface $entityManager) 
{
     $consultation = new Consultation();
    

    $form=$this->createForm(ConsultationType::class,$consultation);


    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $entityManager->persist($consultation);
        $entityManager->flush();
        return $this->redirectToRoute('app_consultation');
    }
    return $this->renderForm('consultation/add.html.twig', ['form' => $form]);

}



}

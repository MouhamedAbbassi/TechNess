<?php

namespace App\Controller\Doctor;

use App\Entity\Ordonnance;
use App\Entity\User;
use App\Form\OrdonnanceType;
use App\Repository\ConsultationRepository;
use App\Repository\OrdonnanceRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ordonnance')]
class OrdonnanceController extends AbstractController
{
    #[Route('/', name: 'app_ordonnance_index', methods: ['GET'])]
    public function index(OrdonnanceRepository $ordonnanceRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('back_office/ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findBy([
                'doctor' => $user
            ]),
        ]);
    }

    #[Route('/{id}/new', name: 'app_ordonnance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdonnanceRepository $ordonnanceRepository, $id, ConsultationRepository $consultationRepository ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $consultation = $consultationRepository->find((int)$id);
        $ordonnance = new Ordonnance();
        $ordonnance->setNomMedecin($user->getNom().' '.$user->getPrenom());
        $ordonnance->setNomPatient($consultation->getNomPatient());
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordonnance->setNomMedecin($user->getNom().' '.$user->getPrenom());
            $ordonnance->setDate(new DateTime());
            $ordonnance->setDoctor($user);
            $ordonnanceRepository->save($ordonnance, true);

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ordonnance_show', methods: ['GET'])]
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('back_office/ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ordonnance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordonnance->setDoctor($user);
            $ordonnanceRepository->save($ordonnance, true);

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/ordonnance/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_ordonnance_delete', methods: ['GET','POST'])]
    public function delete(Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository): Response
    {
            $ordonnanceRepository->remove($ordonnance, true);

        return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    }
}

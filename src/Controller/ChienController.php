<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Form\ChienType;
use App\Repository\ChienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chien')]
final class ChienController extends AbstractController
{
    #[Route('/', name: 'app_chien_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('app_chien_dashboard');
    }

    #[Route('/dashboard', name: 'app_chien_dashboard', methods: ['GET', 'POST'])]
    public function dashboard(ChienRepository $chienRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // 🛠️ Correction Intelephense : On indique explicitement le type de l'objet User
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        $chiens = $isAdmin ? $chienRepository->findAll() : ($user && $user->getProprietaire() ? $chienRepository->findBy(['proprietaire' => $user->getProprietaire()]) : []);

        $chien = new Chien();
        
        // 🛠️ Correction SQL : On passe l'information au formulaire
        $form = $this->createForm(ChienType::class, $chien, [
            'is_admin' => $isAdmin,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 🛠️ Sécurité d'attribution du propriétaire
            if ($chien->getProprietaire() === null) {
                if ($user && $user->getProprietaire()) {
                    $chien->setProprietaire($user->getProprietaire());
                } else {
                    $this->addFlash('error', 'Impossible de créer le chien : aucun propriétaire assigné.');
                    return $this->redirectToRoute('app_chien_dashboard');
                }
            }

            $entityManager->persist($chien);
            $entityManager->flush();

            return $this->redirectToRoute('app_chien_dashboard');
        }

        return $this->render('chien/dashboard_admin.html.twig', [
            'chiens' => $chiens,
            'form'   => $form->createView(),
            'isAdmin' => $isAdmin,
        ]);
    }

    #[Route('/{id}', name: 'app_chien_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Chien $chien): Response
    {
        return $this->render('chien/show.html.twig', [
            'chien' => $chien,
        ]);
    }

    #[Route('/liste', name: 'app_chien_liste')]
    public function chien(ChienRepository $chienRepository): Response
    {
        $chiens = $chienRepository->findAll();
        return $this->render('chien/liste.html.twig', [
            'chiens' => $chiens,
        ]);
    }

    #[Route('/ajouter', name: 'chien_ajouter', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // 🛠️ Même logique que dans le dashboard
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        $chien = new Chien();
        $form = $this->createForm(ChienType::class, $chien, [
            'is_admin' => $isAdmin,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($chien->getProprietaire() === null) {
                if ($user && $user->getProprietaire()) {
                    $chien->setProprietaire($user->getProprietaire());
                } else {
                    $this->addFlash('error', 'Impossible de créer le chien : aucun propriétaire assigné.');
                    return $this->redirectToRoute('chien_ajouter');
                }
            }

            $entityManager->persist($chien);
            $entityManager->flush();

            return $this->redirectToRoute('app_chien_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chien/chien_ajouter.html.twig', [
            'chien' => $chien,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier/{id}', name: 'chien_modification', requirements: ['id' => '\d+'])]
    public function modifier(
        Chien $chien,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        $form = $this->createForm(ChienType::class, $chien, [
            'is_admin' => $isAdmin,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Plus besoin de $entityManager->persist($chien) lors d'un update
            $entityManager->flush();

            $this->addFlash('success', 'Modification correctement effectuée !');

            return $this->redirectToRoute('app_chien_liste');
        }

        return $this->render('chien/edit.html.twig', [
            'chien' => $chien,
            'form'  => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_chien_delete', methods: ['POST'])]
    public function delete(Request $request, Chien $chien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $chien->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chien_liste', [], Response::HTTP_SEE_OTHER);
    }
}
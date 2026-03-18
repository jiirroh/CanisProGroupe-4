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
    public function index(ChienRepository $chienRepository): Response
    {

        return $this->render('home/index.html.twig', [
            'chiens' => $chienRepository->findAll(),
        ]);
    }
    #[Route('/dashboard', name: 'app_chien_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render('chien/dashboard_admin.html.twig');
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
        $chiens = new Chien();
        $form = $this->createForm(ChienType::class, $chiens);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chiens);
            $entityManager->flush();

            return $this->redirectToRoute('app_chien_liste', [], Response::HTTP_SEE_OTHER);
        }
            $chiens = $entityManager->getRepository(Chien::class)->findAll();
        return $this->render('chien/chien_ajouter.html.twig', [
            'chien' => $chiens,
            'form' => $form,
            'chiens' => $chiens,    
        ]);
    }

 

    #[Route('modifier/{id}', name: 'chien_modification', requirements: ['id' => '\d+'],
    defaults: ['id' => null])]
    public function modifier(
        int $id,
        Request $request,
        ChienRepository $chienRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $chien = $chienRepository->find($id);
        $isModification = $chien !== null;
        if (!$chien) {
            throw $this->createNotFoundException('chien non trouvé');
        }

        $form = $this->createForm(ChienType::class, $chien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chien);
            $entityManager->flush();

            $this->addFlash('success', 'Modification correctement effectuée !');

            return $this->redirectToRoute('app_chien_liste');
        }

        return $this->render('chien/edit.html.twig', [
            "chien" => $chien,
            "form" => $form->createView()
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

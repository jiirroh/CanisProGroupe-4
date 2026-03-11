<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // L'URL d'accueil "/" (sans le préfixe /chien)
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // On redirige le visiteur vers la page des chiens
        return $this->redirectToRoute('app_chien_index');
    }
}

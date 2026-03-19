<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'cours' => $coursRepository->findBy([], ['id' => 'DESC'], 3),
        ]);
    }
}
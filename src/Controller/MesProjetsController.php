<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesProjetsController extends AbstractController
{
    /**
     * @Route("/mes/projets", name="app_mes_projets")
     */
    public function index(): Response
    {
        return $this->render('mes_projets/index.html.twig', [
            'controller_name' => 'MesProjetsController',
        ]);
    }
}

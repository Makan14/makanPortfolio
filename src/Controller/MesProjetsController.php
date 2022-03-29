<?php

namespace App\Controller;

use App\Form\ProjetsType;
use App\Entity\MesProjets;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MesProjetsController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 
    }

    /**
     * @Route("/mes/projets", name="app_mes_projets")
     */
    public function index(Request $request): Response
    {
        $projets = new MesProjets(); 
        $form = $this->createForm(ProjetsType::class, $projets);   
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($projets); 
            $this->manager->flush(); 
            return $this->redirectToRoute('app_home'); 
        }


        return $this->render('mes_projets/index.html.twig', [
            'formProjets' => $form->createView(),  
            
        ]);
    }

    /**
     * @Route("/mes/projets", name="app_mes_projets")
     */
    public function index(Request $request): Response
    {
        $competences = $this->manager->getRepository(Competences::class)->findAll();  
        
        return $this->render('mes_projets/index.html.twig', [
            'Projets' => $Projets,  
            
        ]);
    }
}

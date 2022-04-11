<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationsController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 
    }
    
    /**
     * @Route("/formations", name="app_formations")
     */
    public function index(): Response
    {
        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController',
        ]);
    }

    // *************************AFFICHAGE AJOUT FORMATIONS

    /**
     * @Route("/admin/formation/ajout", name="app_formations_ajout")
     */
    public function formationAjout(Request $request): Response 
    {
        $formation = new Formations(); 
        $form = $this->createForm(FormationType::class, $formation);   
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($formation); 
            $this->manager->flush(); 

        }


        return $this->render('formations/ajoutformation.html.twig', [
            'formFormation' => $form->createView(),  
            
        ]);
    }
}

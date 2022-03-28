<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetencesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetencesController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 
    }

    /**
     * @Route("/competences", name="app_competences") 
     */
    public function index(): Response
    {
        return $this->render('competences/index.html.twig', [
            'controller_name' => 'CompetencesController',
        ]);
    }

    /**
     * @Route("/competences/edit/{id}", name="app_competences_edit")
     */
    public function competencesEdit(Competences $competences, Request $request): Response
    {
     
        $form = $this->createForm(CompetencesType::class, $competences); 
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($competences); 
            $this->manager->flush(); 

        }


        return $this->render('competences/editindex.html.twig', [
            'formCompetences' => $form, 
        ]);
    }
}

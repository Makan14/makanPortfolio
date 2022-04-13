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
     * @Route("/admin/competences/ajout", name="app_competences_ajout")
     */
    public function competencesAjout(Request $request): Response 
    {
        $competences = new Competences(); 
        $form = $this->createForm(CompetencesType::class, $competences);   
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($competences); 
            $this->manager->flush(); 

        }


        return $this->render('competences/ajoutCompetences.html.twig', [
            'formCompetences' => $form->createView(),  
            
        ]);
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
     * @Route("/all/competences", name="app_competences_all") 
     */
    public function allcompetence(): Response 
    {
        
        $competences = $this->manager->getRepository(Competences::class)->findAll();  

        // dd($competences);

        return $this->render('competences/index.html.twig', [ 
            'competences' => $competences, 
        ]);  
    
    }

     /**
     * @Route("/admin/all/competences", name="admin_app_competences_all") 
     */
    public function allcompetenceAdmin(): Response 
    {
        
        $allTable = $this->manager->getRepository(Competences::class)->findAll();  

        // dd($competences);

        return $this->render('competences/gestion.html.twig', [ 
            'competences' => $allTable,  
        ]);   
    
    }

    /**
     * @Route("/admin/competences/delete/{id}", name="app_admin_competences_delete")
     */
    public function competencesDelete(Competences $competences): Response 
    {
            $this->manager->remove($competences); 
            $this->manager->flush(); 


        return $this->redirectToRoute('admin_app_competences_all');      
        
    }

    /**
     * @Route("/admin/competences/edit/{id}", name="app_admin_competences_edit")
     */
    public function competencesEdit(Competences $competences, Request $request): Response 
    {
            $formEdit = $this->createForm(CompetencesType::class, $competences);
            $formEdit->handleRequest($request);

            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $this->manager->persist($competences);  
                $this->manager->flush(); 
                return $this->redirectToRoute('admin_app_competences_all');
            }

            return $this->render('competences/editCompetences.html.twig', [
                'formCompetences' => $formEdit->createview(), 
            ]); 
              
            
        
    }


}

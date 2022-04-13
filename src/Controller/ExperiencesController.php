<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Form\ExperiencesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExperiencesController extends AbstractController
{

    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 
    }

     // *************************AFFICHAGE DE TOUTES LES EXPERIENCES  

    /**
     * @Route("/all/experiences", name="app_experiences_all") 
     */
    public function allexperiences(): Response 
    {
        $experiences = $this->manager->getRepository(ExperiencesType::class)->findAll();  

        // dd($experiences);

        return $this->render('experiences/allexperiences.html.twig', [ 
            'experiences' => $experiences, 
        ]);  
    
    } 

    // ******************************************COTER ADMIN*******************************

       // *************************** AFFICHAGE MODIFICATION ET SUPPRESSION

    /**
     * @Route("/admin/experiences/edit/{id}", name="app_admin_experiences_edit")
     */
    public function experiencesEdit(Experiences $experiences, Request $request): Response 
    {
            $formEdit = $this->createForm(ExperiencesType::class, $experiences); 
            $formEdit->handleRequest($request);

            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $this->manager->persist($experiences);  
                $this->manager->flush(); 
                return $this->redirectToRoute('admin_app_experiences_all'); 
            }

            return $this->render('experiences/editexperiences.html.twig', [
                'formExperiences' => $formEdit->createview(), 
            ]);    
    }

     /**
     * @Route("/admin/experiences/delete/{id}", name="app_admin_experiences_delete")
     */
    public function experiencesDelete(Experiences $experiences): Response 
    {
            $this->manager->remove($experiences); 
            $this->manager->flush(); 


        return $this->redirectToRoute('admin_app_experiences_all');           
        
    }

      /**
     * @Route("/admin/all/experiences", name="admin_app_experiences_all") 
     */
    public function allexperiencesAdmin(): Response 
    {
        
        $allTable = $this->manager->getRepository(ExperiencesType::class)->findAll();   

        // dd($experiences);

        return $this->render('experiences/gestion.html.twig', [ 
            'experiences' => $allTable,  
        ]);   
    
    } 

    /**
     * @Route("/experiences", name="app_experiences")
     */
    public function index(): Response
    {
        return $this->render('experiences/index.html.twig', [
            'controller_name' => 'ExperiencesController',
        ]);
    }
}

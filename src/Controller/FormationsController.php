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
    
        // *************************AFFICHAGE AJOUT FORMATIONS
    
        /**
         * @Route("/admin/formation/ajout", name="app_formations_ajout")
         */
        public function formationAjout(Request $request): Response 
        {
            $formations= new Formations();            
            $form = $this->createForm(FormationType::class, $formations);   
            $form->handleRequest($request); 
    
            if ($form->isSubmitted() && $form->isValid()){
                $this->manager->persist($formations); 
                $this->manager->flush();  
    
            }
    
            return $this->render('formations/ajoutformation.html.twig', [
                'formFormation' => $form->createView(),  
                
            ]); 
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

    // *************************AFFICHAGE DE TOUTES LES FORMATIONS 

    /**
     * @Route("/all/formations", name="app_formations_all") 
     */
    public function allformation(): Response 
    {
        $formations = $this->manager->getRepository(Formations::class)->findAll();  

        // dd($formations);

        return $this->render('formations/allformations.html.twig', [ 
            'formations' => $formations, 
        ]);  
    
    } 

    // **********************************************COTER ADMIN

    // *************************** AFFICHAGE MODIFICATION ET SUPPRESSION

    /**
     * @Route("/admin/formations/edit/{id}", name="app_admin_formations_edit")
     */
    public function formationsEdit(Formations $formations, Request $request): Response 
    {
            $formEdit = $this->createForm(FormationType::class, $formations);
            $formEdit->handleRequest($request);

            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $this->manager->persist($formations);  
                $this->manager->flush(); 
                return $this->redirectToRoute('app_formations_all');
            }

            return $this->render('formations/editformations.html.twig', [
                'formformations' => $formEdit->createview(), 
            ]);    
    }

    /**
     * @Route("/admin/formations/delete/{id}", name="app_admin_formations_delete")
     */
    public function formationsDelete(Formations $formations): Response 
    {
            $this->manager->remove($formations); 
            $this->manager->flush(); 


        return $this->redirectToRoute('admin_app_formations_all');           
        
    }

    /**
     * @Route("/admin/all/formations", name="admin_app_formation_all") 
     */
    public function allformationsAdmin(): Response 
    {
        
        $allTable = $this->manager->getRepository(Formations::class)->findAll();   

        // dd($formations);

        return $this->render('formations/gestionformations.html.twig', [ 
            'formations' => $allTable,  
        ]);   
    
    } 

}

<?php

namespace App\Controller;

use App\Form\ProjetsType;
use App\Entity\MesProjets;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MesProjetsController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 
    }

    /**
     * @Route("/admin/formprojets", name="app_form_projets")
     */
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $projets = new MesProjets(); 
        $form = $this->createForm(ProjetsType::class, $projets);   
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $photoProjets = $form->get('images')->getData();
       
            if($photoProjets){
           $originalFilename = pathinfo($photoProjets->getClientOriginalName(), PATHINFO_FILENAME);
           $safeFilename = $slugger->slug($originalFilename);
           $newFilename = $safeFilename.'-'.uniqid().'.'.$photoProjets->guessExtension();
             try {
                $photoProjets->move(
                    $this->getParameter('images'), 
                    $newFilename
                );
             }catch (FileException $e){

             }
              $projets->setImages($newFilename); 
            }else{
                dd("Aucun logo"); 
            } 


            $this->manager->persist($projets); 
            $this->manager->flush(); 
            return $this->redirectToRoute('app_mes_projets'); 
        }


        return $this->render('mes_projets/index.html.twig', [
            'formProjets' => $form->createView()  
            
        ]); 
    }

    // ************************AFFICHAGE DE TOUS MES PROJETS
    /**
     * @Route("/mes/projets", name="app_mes_projets")
     */
    public function mesProjets(Request $request): Response
    {
        $projets = $this->manager->getRepository(MesProjets::class)->findAll();  
        
        return $this->render('mes_projets/allprojets.html.twig', [
            'projets' => $projets,  
            
        ]);
    }


    // *************************** AFFICHAGE MODIFICATION ET SUPPRESSION

    /**
     * @Route("/admin/projets/edit/{id}", name="app_admin_projets_edit")
     */
    public function projetsEdit(MesProjets $projets, SluggerInterface $slugger, Request $request): Response 
    {
            $formEdit = $this->createForm(ProjetsType::class, $projets);
            $formEdit->handleRequest($request);

            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $photoProjets = $formEdit->get('images')->getData();

            if($photoProjets){
                $originalFilename = pathinfo($photoProjets->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoProjets->guessExtension();
                  try {
                     $photoProjets->move(
                         $this->getParameter('images'), 
                         $newFilename
                     );
                  }catch (FileException $e){
     
                  }
                   $projets->setImages($newFilename);
                 }else{
                     dd("Aucun logo"); 
                 } 
                $this->manager->persist($projets);  
                $this->manager->flush(); 
                return $this->redirectToRoute('app_mes_projets'); 
            }

            return $this->render('mes_projets/editprojets.html.twig', [
                'formProjets' => $formEdit->createview(), 
            ]);    
    }

    /**
     * @Route("/admin/projets/delete/{id}", name="app_admin_projets_delete")
     */
    public function projetsDelete(MesProjets $projets): Response 
    {
            $this->manager->remove($projets); 
            $this->manager->flush(); 


        return $this->redirectToRoute('admin_app_projets_all');           
        
    }

    // ***************************AFFICHAGE AJOUT PROJETS 

    /**
     * @Route("/admin/projets/ajout", name="app_projets_ajout")
     */
    public function projetsAjout(Request $request): Response 
    {
        $projets = new MesProjets(); 
        $form = $this->createForm(ProjetsType::class, $projets);   
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($projets); 
            $this->manager->flush(); 
            return $this->redirectToRoute('app_mes_projets'); 


        }


        return $this->render('mes_projets/ajoutprojets.html.twig', [
            'formProjets' => $form->createView(),  
            
        ]);
    }

    // *******************************AFFICHAGE GESTION PROJETS 

    /**
     * @Route("/admin/all/projets", name="admin_app_projets_all") 
     */
    public function allprojetsAdmin(): Response 
    {
        
        $allTable = $this->manager->getRepository(MesProjets::class)->findAll();  

        // dd($projets);

        return $this->render('mes_projets/gestion.html.twig', [ 
            'projets' => $allTable, 
        ]);   
    
    }

    /**
     * @Route("/single/projets/{id}", name="app_view_projets") 
     */
    public function singleProjets(MesProjets $projets): Response 
    {
        
        $projets = $this->manager->getRepository(MesProjets::class)->find($projets);

        return $this->render('mes_projets/singleProjets.html.twig', [
            'projets' => $projets,
             
        ]);  
    
    }

}

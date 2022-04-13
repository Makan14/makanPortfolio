<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager; 
    }
    
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->manager->persist($contact);  
                $this->manager->flush(); 
                // return $this->redirectToRoute('admin_app_experiences_all'); 
            }
        
        return $this->render('contact/index.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }
}

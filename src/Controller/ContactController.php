<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash){

        $this->manager = $manager;
        $this->flash = $flash; 
    }
    // ************************************AFFICHAGE FORMULAIRE DE CONTACT
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->manager->persist($contact);  
                $this->manager->flush(); 
                $this->flash->add('success', 'votre message a bien etais envoyé, merci'); 
                return $this->redirectToRoute('app_contact'); 
            }
        
        return $this->render('contact/index.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }
}

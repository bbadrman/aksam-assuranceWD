<?php

namespace App\Controller;
  
use App\Form\SiteType;
use App\Entity\Prospect; 
use App\Repository\ProspectRepository;
use Doctrine\ORM\EntityManagerInterface;  
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

/**
 * @Route("/site") 
 * 
 */

 class SiteController extends AbstractController
{
     
    
    /**
     * @Route("/", name="app_site_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProspectRepository $prospectRepository): Response
    {
        $success_message = null;
        $prospect = new Prospect();
        $form = $this->createForm(SiteType::class, $prospect );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $prospect->setAutor($this->getUser());
            $prospectRepository->add($prospect, true);
           
            $this->addFlash('success', 'Votre demande sera traitée dans les meilleurs délais !');
            return $this->redirectToRoute('app_site_new', [], Response::HTTP_SEE_OTHER);
           
        }
     
        return $this->renderForm('prospect/sitep.html.twig', [
            'prospect' => $prospect,
            'form' => $form,
            'success_message' => $success_message
        ]);
    }

    /**
     * @Route("/add", name="app_site_add", methods={"GET", "POST"})
     */
    public function add(Request $request, ProspectRepository $prospectRepository): Response
    {
        $success_message = null;
        $prospect = new Prospect();
        $form = $this->createForm(SiteType::class, $prospect );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $prospect->setAutor($this->getUser());
            $prospectRepository->add($prospect, true);
           
            $this->addFlash('success', 'Votre demande sera traitée dans les meilleurs délais !');
            return $this->redirectToRoute('app_site_new', [], Response::HTTP_SEE_OTHER);
           
        }
     
        return $this->renderForm('prospect/sitepadd.html.twig', [
            'prospect' => $prospect,
            'form' => $form,
            'success_message' => $success_message
        ]);
    }

   
}
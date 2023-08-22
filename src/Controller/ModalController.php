<?php

namespace App\Controller;
  
use App\Entity\Prospect;
use App\Form\ProspectType;
use App\Search\SearchProspect;
use App\Form\SearchProspectType;
use App\Repository\ProspectRepository;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

 
class ModalController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    

     /**
     * @Route("/{id}/editm", name="app_prospect_editm", methods={"GET", "POST"}) 
     */
    public function editm(Request $request, Prospect $prospect, ProspectRepository $prospectRepository, $id ): Response
    {
        $prospect= $prospectRepository->find($id);
        $form = $this->createForm(ProspectType::class, $prospect, [
            'editing' => true,
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prospectRepository->add($prospect, true);
           
            $this->addFlash('info', 'Votre Prospect a été afficté avec succès!');
            // $route = $request->attributes->get('_route');
            return $this->redirectToRoute('prospect_reaffecter', [], Response::HTTP_SEE_OTHER);
            // return $this->redirectToRoute('app_prospect_editm', ['id' => $prospect->getId()], Response::HTTP_SEE_OTHER);
           
            // $currentRoute = $request->attributes->get('_route');
            // $redirectTo = null;
            
            // if ($currentRoute === 'prospect_reaffecter' || $currentRoute === 'prospect_search' || $currentRoute === 'app_prospect_index') {
            //     $redirectTo = $this->generateUrl($currentRoute);
            // } else {
            //     $redirectTo = $this->generateUrl('app_prospect_index');
            // }
            
            // return $this->redirectToRoute($redirectTo, [], Response::HTTP_SEE_OTHER);
        
               

        }

        return $this->render('partials/_show_modal.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
        ]); 
    }
}
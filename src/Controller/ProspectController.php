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

/**
 * @Route("/prospect")
 * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
 * 
 */

 class ProspectController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="app_prospect_index", methods={"GET", "POST"}) 
     */
    public function index(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response
    {  
        
        
      
        $form = $this->createForm(SearchProspectType::class);
        $form->handleRequest($request);

            // Pour avoir tous les prospect en taut que je suis admin 
        $user = $security->getUser();
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true)) {
           
            // je recupere les prospects qui son pas encors affecter
            $prospect =  $prospectRepository->findByUserPasAffecter();
            $request->getSession()->set('security', count($prospect) );
            
        } else if (in_array('ROLE_TEAM', $user->getRoles(), true)) {
          
                // je recupe seulement les prospects affecter au mon equipe
            $prospect =  $prospectRepository->findByUserChefEquipe($user);
            $request->getSession()->set('security', count($prospect) );
            
        }

        // Alors si je suis pas admin  je recupere selement les prospect attacher a moi 
        else {
            
            $prospect =  $prospectRepository->findByUserConect( $security->getUser()->getId());
       
            $request->getSession()->set('security', count($prospect) );
        }

      
        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="app_prospect_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProspectRepository $prospectRepository): Response
    {
        $prospect = new Prospect();
        $form = $this->createForm(ProspectType::class, $prospect );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $prospect->setAutor($this->getUser());
            $prospectRepository->add($prospect, true);
           
            $this->addFlash('success', 'Votre Prospect a été ajouté avec succès!');
            return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
        }
     
        return $this->renderForm('prospect/new.html.twig', [
            'prospect' => $prospect,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_prospect_show", methods={"GET"})
     */
    public function show(Prospect $prospect): Response
    {
        return $this->render('prospect/show.html.twig', [
            'prospect' => $prospect,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_prospect_edit", methods={"GET", "POST"}) 
     */
    public function edit(Request $request, Prospect $prospect, ProspectRepository $prospectRepository): Response
    {
        $form = $this->createForm(ProspectType::class, $prospect, [
            'editing' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prospectRepository->add($prospect, true);
            
            $this->addFlash('info', 'Votre Prospect a été afficté avec succès!');
            return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partials/_show_modal.html.twig', [
            'prospect' => $prospect,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}", name="app_prospect_delete", methods={"POST"})
     */
    public function delete(Request $request, Prospect $prospect, ProspectRepository $prospectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prospect->getId(), $request->request->get('_token'))) {
            $prospectRepository->remove($prospect, true);
        }

        return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
    }
}
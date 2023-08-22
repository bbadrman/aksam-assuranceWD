<?php

namespace App\Controller;
  
 
use App\Entity\User;
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

 
class SearchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
   
   /**
     * @Route("/search_prospect", name="prospect_search", methods={"GET"})
     * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
     */
    public function search(Request $request, ProspectRepository $prospectRepository, Security $security): Response
    {
  
        
        $data = new SearchProspect();
        $data->page = $request->get('page', 1);
        
        $form = $this->createForm(SearchProspectType::class, $data);
        $form->handleRequest($request);
        $user = $security->getUser();
        $prospect = $prospectRepository->findSearchChef($data, $user);

       if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty() ) {
        {
        $data->page = $request->query->get('page', 1);
        $prospect = $prospectRepository->findSearch($data, $user);
           
            return $this->render('prospect/index.html.twig', [
                'prospects' => $prospect,
                'search_form' => $form->createView()   ]);
         
      
       }
       }
    

        return $this->render('prospect/search.html.twig', [
            'prospects' => $prospect,
            'search_form' => $form->createView(),
        ]);
    }
    
    
}
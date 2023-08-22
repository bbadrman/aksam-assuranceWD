<?php

namespace App\Controller;
  
 
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

 
class ReaffecterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

   /**
     * @Route("/prospect_reaffecter", name="prospect_reaffecter", methods={"GET"})
     * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
     */
    public function refect(Request $request, ProspectRepository $prospectRepository, Security $security): Response
    {
  
        $data = new SearchProspect();
        $data->page = $request->get('page', 1); 

        $form = $this->createForm(SearchProspectType::class, $data);
        $form->handleRequest($request);
        
     
            // $prospect =  $prospectRepository->findByUserAffecter();
            $user = $security->getUser();
            if (in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true)) {
               
                // je recupere les prospects qui son pas encors affecter
                $prospect = $prospectRepository->findByUserAffecter($data);
                $request->getSession()->set('security', count($prospect) );
                
            } else if (in_array('ROLE_TEAM', $user->getRoles(), true)) {
          
                // je recupe seulement les prospects affecter au mon equipe
            $prospect =  $prospectRepository->findByUserAffecterChef($user, $data);
            $request->getSession()->set('security', count($prospect) );
            
        }
        // else {
            
        //     $prospect =  $prospectRepository->findByUserConect( $security->getUser()->getId());
       
        //     $request->getSession()->set('security', count($prospect) );
        // }


        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'search_form' => $form->createView()
             
            
        ]);
    }
}

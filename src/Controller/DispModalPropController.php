<?php

namespace App\Controller;
  
use App\Entity\Prospect;
use App\Form\ProspectType;
use App\Search\SearchProspect;
use App\Form\SearchProspectType;
use App\Repository\ProspectRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 

/**
 * @Route("/prospect/modal")
 * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
 * 
 */

 class DispModalPropController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="dis_modal_prosp", methods={"GET"}) 
     */
    public function display(Prospect $prospect): Response
    {  
        
        
      
        return $this->render('partials/_disp_modal_team.twig'  , [
            'prospect' => $prospect,
        ]);
    }


      /**
     * @Route("/disply-team/{id}", name="team_show", methods={"GET"})
     */
    public function show(TeamRepository $teamRepository, int $id): JsonResponse
    {
        $team = $teamRepository->find($id);

        if ($team) {
            return $this->json([
                'status' => 200,
                'brand' => $team,
            ]);
        } else {
            return $this->json([
                'status' => 404,
                'message' => 'Marque introuvable'
            ]);
        }
    }
   
}
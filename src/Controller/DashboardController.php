<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Prospect;
use App\Service\StatsService;
use App\Repository\TeamRepository;
use App\Repository\UserRepository; 
use App\Repository\ProspectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DashboardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="dashboard")
     * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
     
     * @return Response  
     */
    public function index(Request $request,  ProspectRepository $prospectRepository, UserRepository $userRepository,  TeamRepository $teamRepository,  StatsService $statsService,  Security $security ): Response
    {
        $user = $security->getUser();
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true)) {
           
            // je recupere les prospects qui son pas encors affecter
            $prospect =  $prospectRepository->findByUserPasAffecter();
            $request->getSession()->set('security', count($prospect) );
            
        } else if (in_array('ROLE_TEAM', $user->getRoles(), true)) {
          
                // je recupe seulement les prospects affecter au mon equipe
            $prospect =  $prospectRepository->findOneByChef($user);
            $request->getSession()->set('security', count($prospect) );
            // dd($prospect);
            
        }
        else {
            
            $prospect =  $prospectRepository->findByUserConect( $security->getUser()->getId());
       
            $request->getSession()->set('security', count($prospect) );
        }

       
        $request->getSession()->set('security', count($prospect) );

        // generer les données avec statistiques
        $stats    = $statsService->getStats();
        $prosStat =  $prospectRepository->findAll();

        //si tu veux quand tu deconnecter redirect to connexion:
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $userRepository->findAll();
        $team = $teamRepository->findByTeamConect($user);
        $teams = $teamRepository->findAll();
        // dd($teams);
        return $this->render('dashboard/index.html.twig', [
            'stats'    => $stats,
            'users' => $users,
            'teams' => $team, 
            'team' => $teams,
            'prospects' => $prospect,
            'prospstat' => $prosStat]);

            
        
        
    }

    /**
     * Permet d'afficher une seule annonce
     * 
     *  @Route("/home/show/{id}", name="dashboard_show")
     *
     * @return Response  
     */

     public function show(Prospect $pro)
     {
         //je récuperer l'annonce qui correspond au slug
         //  $ad = $repo->findOneBySlug($slug);
         return $this->render('dashboard/show.html.twig', [
             'pro' => $pro
         ]);
     }



      /**
     * Permet d'afficher tous les teams
     * 
     *  @Route("/home/list", name="dashboard_list")
     *
     * @return Response  
     */

     public function list(TeamRepository $teamRepository)
     {
        $teams = $teamRepository->findAll();
         return $this->render('dashboard/list.html.twig', [
            'team' => $teams,
         ]);
     }

      /**
     * Permet d'afficher tous les teams
     * 
     *  @Route("/home/show/{id}", name="dashboard_show", methods={"GET"})
     *
     * @return Response  
     */

     public function listShow(Team $team)
     {
        
         return $this->render('partials/_modal_disp_team.html.twig', [
            'team' => $team,
         ]);
     }

    //  /**
    //  * @Route("/shop", name="shop")
    //  */
    // public function shop( StatsService $statsService): Response
    // {

    //     $stats    = $statsService->getStats();
     
    //     return $this->render('header.html.twig', [
    //         'stats'    => $stats,
    //         ]);

 
    // }
    // public function total(OrderRepository $order ): Response
    // {
    //     $totalOrder = count($orderRepository->findAll());
    
    // }
    //     return $this->render('@backend/dashboard/index.html.twig', [
    //         'totalAmount'  => $statiProduct,
          
    //     ]);
    

}
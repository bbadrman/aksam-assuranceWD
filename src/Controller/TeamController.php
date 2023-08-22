<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Product;
use App\Form\TeamType; 
use App\Search\SearchTeam;
use App\Form\SearchTeamType;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/team")
 * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
 */
class TeamController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="app_team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository, Request $request): Response
    {   
        $data = new SearchTeam();
        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchTeamType::class, $data);
        $form->handleRequest($request);
        
        $teams = $teamRepository->findSearch($data);
         
        return $this->render('team/index.html.twig', [
            'teams' => $teams,
            'search_form' => $form->createView()
        ]);
    }

/**
 * @Route("/teams-test/", name="teams-test", methods={"GET", "POST"})
 */
    public function testuser(UserRepository $userRepository){
          $users = $userRepository->findAll();
        $jsonData = array();
        $idx = 0; 
        foreach($users as $user) {  
            $temp = array(
               'id' => $user->getId(),  
               'name' => $user->getFirstname(),  
               'prenom' => $user->getLastname(),  
               
            );   
            $jsonData[$idx++] = $temp;  
         } 
        return $this->json([
            'status' => 400,
            'user' => $jsonData
        ]);
    }
    /**
     * @Route("/new-team", name="team_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $team = new Team();

        $team->setName($request->get('name'));

        $team->setDescription($request->get('description'));

        $errors = $validator->validate($team);

        $errorMessages = array();

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json([
                'status' => 400,
                'errors' => $errorMessages,
            ]);
        } else {
            $this->entityManager->persist($team);
            $this->entityManager->flush();

            return $this->json([
                'status' => 200,
                'message' => 'Equipe a bien été ajouté',
            ]);
        }
    }

    /**
     * @Route("/new", name="app_team_new", methods={"GET","POST"}) 
     */
    public function add(Request $request, TeamRepository $teamRepository): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($team->getUsers() as $user) {
                $user->setTeams($team);
            }
            $teamRepository->add($team, true);
            $this->addFlash('success', 'Equipe a été ajouté avec succès!');
            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_team_show", methods={"GET"})
     */
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_team_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
           
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($team->getUsers() as $user) {
                $user->setTeams($team);
            }
            
            $teamRepository->add($team, true);

             
            $this->addFlash('info', 'Votre equipe a été modifié avec succès!');
            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_team_delete", methods={"POST"}) 
     * @IsGranted("ROLE_SUPER_ADMIN", message="Tu ne peut pas acces a cet ressource")
     */
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            $teamRepository->remove($team, true);
        }
        $this->addFlash('danger', 'Votre equipe a été supprimé avec succès!');
        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }


    
}

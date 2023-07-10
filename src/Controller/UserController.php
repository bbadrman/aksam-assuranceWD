<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Product;
use App\Search\SearchUser;
use App\Form\SearchUserType;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/utilisateurs")
 */
class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, TeamRepository $teamRepository, Request $request): Response
    {
        
        $data = new SearchUser();
        $data->page = $request->get('page', 1);
        
        $form = $this->createForm(SearchUserType::class, $data);
        $form->handleRequest($request);
        $users = $userRepository->findSearchUser($data);
        $teams = $teamRepository->findAll();
        
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'teams' => $teams,
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/nouveau-utilisateur", name="user_new", methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN", message="Tu ne peut pas acces a cet ressource")
     */
    public function new(Request $request, UserPasswordHasherInterface $encoder ): Response
    {
        $user = new User();
      
        $form = $this->createForm(UserType::class, $user);
      
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach ($user->getFonctions() as $fonction) {
                $fonction->addUser($user);
            }

            foreach ($user->getProducts() as $product) {
                $product->addUser($user);
            }
            
            // $user->setStatus(1);
            //  $data = $form->getData();
            //   dd($data);
            $password = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            // $user->setRoles($data['roles']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre User a été ajouté avec succès!');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/afficher-utilisateur/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {


        return $this->render('user/show.html.twig', [
            'user' => $user,

        ]);
    }

    /**
     * @Route("/{id}/modifier-utilisateur", name="user_edit" )
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            
            // foreach ($user->getFonctions() as $fonction) {
            //     $fonction->addUser($user);
            // }
             
            $userRepository->add($user, true);
            $password = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
           
        //    $this->entityManager->persist($user);
            $this->entityManager->flush();
            // dd($user);
            $this->addFlash('success', 'Votre User a été modifié avec succès!');

            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash('danger', 'Votre User a été supprimé avec succès!');
        }

        return $this->redirectToRoute('user_index');
    }


    /**
     * @Route("/activer/{id}", name="activer")
     */

    public function activer(User $user)  {

        $user->setStatus(($user->getStatus())?false:true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response("true");

    }

   

}

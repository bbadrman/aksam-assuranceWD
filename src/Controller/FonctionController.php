<?php

namespace App\Controller;

use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Search\SearchFonction;
use App\Form\SearchFonctionType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/fonctions")
 */
class FonctionController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="fonction_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(FonctionRepository $fonctionRepository, Request $request): Response
    {

        $data = new SearchFonction();
        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchFonctionType::class, $data);
        $form->handleRequest($request);

        $fonctions = $fonctionRepository->findSearch($data);

        return $this->render('fonction/index.html.twig', [
            'fonctions' => $fonctions,
            'search_form' => $form->createView()


        ]);
    }

    /**
     * @Route("/new-fonction", name="fonction_add", methods={"GET", "POST"}) 
     */
    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {

        $fonction = new Fonction();

        $fonction->setName($request->get('name'));

        $fonction->setDescription($request->get('description'));
        // dump($fonction);
        // die();
        $errors = $validator->validate($fonction);
        
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
            $this->entityManager->persist($fonction);
            $this->entityManager->flush();

            return $this->json([
                'status' => 200,
                'message' => 'Fonction a bien été ajouté',
            ]);
        }
    }

    /**
     * @Route("/nouveau_fonction", name="fonction_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $fonctions = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonctions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->entityManager->persist($fonctions);
            $this->entityManager->flush();

            /** @var FlashBag */
            $this->addFlash('success', "Le produit à bien été ajouté au panier ");


            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('fonction/new.html.twig', [

            'Fonction' => $fonctions,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/afficher-fonction/{id}", name="fonction_show", methods={"GET"})
     */
    public function show(Fonction $fonction): Response
    {
        return $this->render('fonction/show.html.twig', [
            'fonction' => $fonction
        ]);
    }

    /**
     * @Route("/{id}/modifier-fonction", name="fonction_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Fonction $fonction): Response
    {
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($fonction->getUsers() as $user) {
                $user->addFonction($fonction);
            }

            $this->entityManager->flush();

            /** @var FlashBag */
            $this->addFlash('info', "La Fonction à bien été modifie ");

            return $this->redirectToRoute('fonction_index');
        }

        return $this->render('fonction/edit.html.twig', [
            'fonction' => $fonction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fonction_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Fonction $fonction)
    {
        if ($this->isCsrfTokenValid('delete' . $fonction->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($fonction);
            $this->entityManager->flush();
        }
        $this->addFlash('danger', "La fonction à bien été supprimer ! ");
        return $this->redirectToRoute('fonction_index');
    }
}

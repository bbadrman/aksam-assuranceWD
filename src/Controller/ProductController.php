<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/product") 
 */
class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="app_product_index", methods={"GET"}) 
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }


     /**
     * @Route("/new-product", name="product_new", methods={"GET", "POST"}) 
     */
    public function new(Request $request, ValidatorInterface $validator): JsonResponse
    {
        
        $product = new Product();

        $product->setName($request->get('name'));

        $product->setDescrption($request->get('descrption'));
         
        $errors = $validator->validate($product);

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
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->json([
                'status' => 200,
                'message' => 'Produit a bien été ajouté',
            ]);
        }
    }

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function add(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach ($product->getUsers() as $user) {
                $user->addProduct($product);
            }
            $productRepository->add($product, true);
            $this->addFlash('success', 'le Produit a été ajouté avec succès!');
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"}) 
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($product->getUsers() as $user) {
                $user->addProduct($product);
            }
            
            $productRepository->add($product, true);
            $this->addFlash('info', 'Votre Produit a été modifié avec succès!');
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN", message="Tu ne peut pas acces a cet ressource")
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }
        $this->addFlash('danger', 'Votre Produit a été supprimé avec succès!');
        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

   
}


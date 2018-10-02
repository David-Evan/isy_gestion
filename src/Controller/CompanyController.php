<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Form\ProductType;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company")
     */
    public function index(){
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }

    /**
     * @Route("/company/products", name="company_product_list", methods={"GET","HEAD"})
     */
    public function listProduct(){
        $products = $this->getDoctrine()
                          ->getRepository(Product::class)
                          ->findAll();

        return $this->render('company/product-list.html.twig', [
            'Products' => $products,
        ]);
    }

    /**
     * @Route("/company/products/add", name="company_product_add")
     */
    public function addProduct(Request $request){

        $product = new Product();
        $form =  $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été ajouté !'
            );

            return $this->redirectToRoute('company_product_list');
        }

        return $this->render('company/product-add.html.twig', [
            'AddProductForm' => $form->createView(),  
        ]);
    }

    /**
     * @Route("/company/products/update/{id}", name="company_product_update", requirements={"id"="\d+"})
     */
    public function updateProduct(Request $request, Product $product){
        
        $form =  $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été modifé !'
            );

            return $this->redirectToRoute('company_product_list');
        }

        return $this->render('company/product-update.html.twig', [
            'UpdateProductForm' => $form->createView(),  
        ]);
    }
}
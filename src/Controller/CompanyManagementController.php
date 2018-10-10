<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\{Product, UserCompany};
use App\Form\{ProductType, UserCompanyType};

class CompanyManagementController extends AbstractController
{
    /**
     * @Route("/company/products", name="company_product_list", methods={"GET"})
     */
    public function productList(){

        $products = $this->getDoctrine()
                          ->getRepository(Product::class)
                          ->findAll();

        return $this->render('company/product-list.html.twig', [
            'Products' => $products,
        ]);
    }

    /**
     * @Route("/company/products/add", name="company_product_add", methods={"GET", "POST"})
     */
    public function productAdd(Request $request){

        $product = new Product();
        $form =  $this->createForm(ProductType::class, $product)
                      ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()
                                  ->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success','Votre produit a bien été ajouté !');

            return $this->redirectToRoute('company_product_list');
        }

        return $this->render('company/product-add.html.twig', [
                            'AddProductForm' => $form->createView(),  
        ]);
    }

    /**
     * @Route("/company/products/update/{id}", name="company_product_update", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function productUpdate(Request $request, Product $product){
        
        $form =  $this->createForm(ProductType::class, $product)
                      ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $entityManager = $this->getDoctrine()
                                  ->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success','Votre produit a bien été modifié !');
            
            return $this->redirectToRoute('company_product_list');
        }

        return $this->render('company/product-update.html.twig', [
            'UpdateProductForm' => $form->createView(),  
        ]);
    }

    /**
     * @Route("/company/products/delete/{id}", name="company_product_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productDelete(Product $product){

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('info','Le produit a bien été supprimé.');
        
        return $this->redirectToRoute('company_product_list');
    }

    /**
     * @Route("/company/options/", name="company_options", methods={"GET", "POST"})
     */
    public function companyParams(Request $request){

        $userCompany = $this->getUser()->getCompany();

        $form =  $this->createForm(UserCompanyType::class, $userCompany)
                      ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()
                              ->getManager();
                              
        $entityManager->persist($userCompany);
        $entityManager->flush();

        $this->addFlash('success','Votre société a bien été modifié !');

            return $this->redirectToRoute('company_options');
        }

        return $this->render('company/company-params.html.twig', [
            'UserCompanyForm' => $form->createView(),   
        ]);
    }
}
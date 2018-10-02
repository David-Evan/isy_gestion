<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company")
     */
    public function index()
    {
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }

    /**
     * @Route("/company/products", name="company_products_list")
     */
    public function products(){
        $products = $this->getDoctrine()
                        ->getRepository(Product::class)
                        ->findAll();

        if (!$products) {
        throw $this->createNotFoundException('No product found');
        }

        return $this->render('company/products-list.html.twig', [
            'Products' => $products,
        ]);
    }
}
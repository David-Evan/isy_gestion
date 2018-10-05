<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class CRMController extends AbstractController
{
    /*
    @Route("/crm", name="crm")
    public function index(){

        return $this->render('CRM/index.html.twig', [
            
        ]);
    }
    */

    /**
     * @Route("/crm/customers", name="crm_customer_list")
     */
    public function customerList()
    {
        return $this->render('CRM/customers.html.twig', [
            
        ]);
    }
}

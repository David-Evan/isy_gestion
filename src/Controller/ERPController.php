<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ERPController extends AbstractController
{
    /**
     * @Route("/erp", name="erp")
     */
    public function index()
    {
        return $this->render('ERP/quotation-view.html.twig', [

        ]);
    }
}

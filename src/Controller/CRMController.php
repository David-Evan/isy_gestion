<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CRMController extends AbstractController
{
    /**
     * @Route("/crm", name="crm")
     */
    public function index()
    {
        return $this->render('CRM/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/crm/client", name="crm_client")
     */
    public function client()
    {
        return $this->render('CRM/client.html.twig', [
            
        ]);
    }
}

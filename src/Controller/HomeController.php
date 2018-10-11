<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\{Customer};

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/home", name="homepage")
     */
    public function index()
    {
        $customer = $this->getDoctrine()
                         ->getRepository(Customer::class)
                         ->findAll([], ['dateCreate' => 'DESC'], 5);

        return $this->render('home/index.html.twig', [
            'LastCustomers' => $customer,
        ]);
    }

    /**
     * @Route("/licence", name="licence")
     */
    public function licence()
    {
        return $this->render('home/licence.html.twig', [  
        ]);
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacy()
    {
        return $this->render('home/privacy.html.twig', [            
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/home", name="homepage")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            
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

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Service\StatsFactory;

/**
 * Stats controller provide a REST API to get JSON Data for stats
 */
class StatsController extends AbstractController
{
    /**
     * @Route("/stats/customers/news/{days}", name="stats_new_customers",
     *                                        requirements={"days"="\d+"},
     *                                        defaults={"days"=7},
     *                                        methods={"GET"})
     */
    public function getNewCustomers(StatsFactory $stats, $days)
    {
        $newCustomersJSON =  json_encode($stats->getNewCustomersForPreviousDays($days), JSON_PRETTY_PRINT);

        $response = new Response($newCustomersJSON);
        $response->headers->set('Content-Type', 'application/json');
    
        return $response;
    }
}

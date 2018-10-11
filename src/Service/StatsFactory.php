<?php

namespace App\Service;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

use App\Entity\{Customer};

/**
 * Get Stats
 */
class StatsFactory
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Return total of customers
     */
    public function getTotalCustomers() : ?int {
        return $this->doctrine->getRepository(Customer::class)
                              ->getTotalCustomers(); 
    }

    /**
     * Return an array with date and number of new customers for previous days.
     * @param $days - days from now
     * @return array of stats
     */
    public function getNewCustomersForPreviousDays(int $days = 7) : ?array {
        return $this->doctrine->getRepository(Customer::class)
                              ->getTotalCustomerAddEachDay($days); 
    }
}
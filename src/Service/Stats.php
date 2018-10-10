<?php

namespace App\Service;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

use App\Entity\{Customer};

/**
 * Get Stats
 */
class Stats 
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getTotalCustomers() : ?int {
        return $this->doctrine->getRepository(Customer::class)
                              ->getTotalCustomers(); 
    }
}
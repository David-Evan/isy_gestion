<?php

namespace App\Service;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

use Symfony\Component\Filesystem\Filesystem;


use App\Entity\{Customer};

/**
 * Get Stats
 */
class StatsFactory
{
    
    const CACHE_DIR = '../var/isy-gestion/cache/stats/';

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
        
        $today = new \DateTime();
        $cacheFileName = 'newCustomers-'.$today->format('Y-m-d').'.cache';

        if(file_exists(self::CACHE_DIR.$cacheFileName))
            return $this->readCacheFile($cacheFileName);

        $data = $this->doctrine->getRepository(Customer::class)
                               ->getTotalCustomerAddEachDay($days);
        
        $this->createCacheFile($cacheFileName, $data);
        return $data;
    }

    public function createCacheFile($fileName, $data){
        $fileSystem = new Filesystem();
     
        if(!$fileSystem->exists(self::CACHE_DIR))
        {
            try {
                $fileSystem->mkdir(self::CACHE_DIR);
            } 
            catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at ".$exception->getPath();
            }
        }

        $fileSystem->dumpFile(self::CACHE_DIR.$fileName, serialize($data));

    }

    public function readCacheFile($fileName){
        $data = file_get_contents(self::CACHE_DIR.$fileName);

        return unserialize($data);
    }
}
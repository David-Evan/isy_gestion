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

    private $newCustomersStats_CacheFilePath;

    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;

        $today = new \DateTime();
        $this->newCustomersStats_CacheFilePath = self::CACHE_DIR.'newCustomers-'.$today->format('Y-m-d').'.cache';
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
        
        

        if(file_exists($this->newCustomersStats_CacheFilePath))
            return $this->readCacheFile($this->newCustomersStats_CacheFilePath);

        $data = $this->doctrine->getRepository(Customer::class)
                               ->getTotalCustomerAddEachDay($days);
        
        $this->createCacheFile($this->newCustomersStats_CacheFilePath, $data);
        return $data;
    }

    public function createCacheFile($fileName, $data){
        $fileSystem = new Filesystem();

        $fileSystem->dumpFile($fileName, serialize($data));

    }

    public function readCacheFile($fileName){
        $data = file_get_contents($fileName);

        return unserialize($data);
    }

    public function destroyCacheFileNewCustomersStats(){
        $fileSystem = new Filesystem();

        if($fileSystem->exists($this->newCustomersStats_CacheFilePath))
            $fileSystem->remove($this->newCustomersStats_CacheFilePath);
    }
}
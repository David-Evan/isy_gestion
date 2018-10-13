<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * Get all customer (paginated)
     * @return Paginator
     */
    public function getAddressBookCustomers(int $page, int $nbPerPage = 12)
    {
        $query =  $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
            ;
        
        return new Paginator($query, true);
    }

    /**
     * Get total customers number (count)
     * @return int $totalCustomer
     */
    public function getTotalCustomers()
    {
        return     $this->createQueryBuilder('c')
                        ->select('COUNT(c)')
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    /**
     * Return date + total customer for each previous 
     * @param int $days
     * @return array('date' => 'YYYY-MM-DD', 'newCustomers' => 'int')
     */
    public function getTotalCustomerAddEachDay(int $days = 7)
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT DATE(date_create) AS period, 
                COUNT(*) AS newCustomers 
                FROM customer
                WHERE DATE(date_create) > (NOW() - INTERVAL :days DAY)
                GROUP BY DATE(date_create)';
        ;
        $stmt = $conn->prepare($sql);
        $stmt->execute(['days' => $days]);

        /**
         * You will get with this query a table for each day (last 7 days)
         * 2018-10-11    5
         * 2018-10-13    8
         * yyyy-mm-dd
         * 
         * But no data for days with no results
         */
        $partialTable = $stmt->fetchAll();

        $finalTable = [];
        $today = date("Y-m-d");

        // We start from the past : Last xx days. And Go to now with day + 1 (-1 from past) at each loop
        for($i = $days ; $i >= 0 ; $i--)
        {
            $previousDay = date('Y-m-d', strtotime($today . '- '.$i.' day'));
            $finalTable[] = ['period' => $previousDay, 'newCustomers' => 0];
        }

        foreach ($partialTable as $partialLine){

            foreach($finalTable as $finalLineKey => $finalLineValue){
                
                if(isset($finalLineValue['period'])){
                    
                    if($partialLine['period'] == $finalLineValue['period']){
                        
                        $finalTable[$finalLineKey]['newCustomers'] = $partialLine['newCustomers'];
                    }
                }
            }
        }
        /**
         * Now, we have a table with empty value : eg :
         *   2018-10-11    5
         *   2018-10-12    0 
         *   2018-10-13    8
         */
        return  $finalTable;
    }

    /**
     * Return all customer like matched pattern (LIKE '%pattern%')
     *  - Looking only into email / name
     * @return CustomersCollection
     */
    public function getCustomersLike($pattern)
    {
        return $this->createQueryBuilder('c')
                    ->where('c.email LIKE :pattern')
                    ->orWhere('c.name LIKE :pattern')
                    ->setParameter('pattern', '%'.$pattern.'%')
                    ->getQuery()
                    ->getResult();
    }
}
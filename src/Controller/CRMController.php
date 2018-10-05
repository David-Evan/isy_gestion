<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customer;

class CRMController extends AbstractController
{
    /*
    @Route("/crm", name="crm")
    public function index(){

        return $this->render('CRM/index.html.twig', [
            
        ]);
    }
    */

    /**
     * @Route("/crm/customers", name="crm_customer_list")
     * @Route("/crm/prospectives", name="crm_prospective_list")
     */
    public function customerList()
    {
        $customerRepository = $this->getDoctrine()->getRepository(Customer::class);
        
        $allCustomers = $customerRepository->findAll();
        $prospectiveCustomers = $customerRepository->findByIsProspectiveCustomer(true);
        $onlyCustomers = $customerRepository->findByIsProspectiveCustomer(false);

        return $this->render('CRM/customer-list.html.twig', [
            'AllCustomers' => $allCustomers,
            'ProspectiveCustomers' => $prospectiveCustomers,
            'OnlyCustomers' => $onlyCustomers,
        ]);
    }
}

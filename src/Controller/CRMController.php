<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\{Customer, Address};

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
     * @Route("/crm/customers", name="crm_customer_list", methods={"GET"})
     * @Route("/crm/prospectives", name="crm_prospective_list", methods={"GET"})
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


    /**
     * @Route("/crm/customers/{id}", name="crm_customer_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function customerViewOne(Customer $customer)
    {
        return $this->render('CRM/customer-view.html.twig', [
            'Customer' => $customer,
            ]);
    }

    /**
     * @Route("/crm/customers/{id}/detail", name="crm_customer_detail", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function customerDetails(Customer $customer)
    {
        return $this->render('CRM/customer-detail.html.twig', [
            'Customer' => $customer,
            ]);
    }

    /**
     * @Route("/crm/customers/delete/{id}", name="crm_customer_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function customerDelete(Customer $customer){

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($customer);
        $entityManager->flush();

        $this->addFlash('info','Le client / prospect a bien été supprimé.');
        
        return $this->redirectToRoute('crm_customer_list');
    }
}

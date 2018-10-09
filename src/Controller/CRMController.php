<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\{Customer, Address, EventType, Event, CustomerComment};

use App\Form\{CustomerType, CustomerCommentType};

use App\Service\EventCreator;

class CRMController extends AbstractController
{

    const PAGINATION_ADDRESSBOOK = 12, // Addressbook contacts per page
          PAGINATION_EVENTS  = 8;    // Timeline events per page
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
     * @Route("/crm/customers/{id}/{page}", name="crm_customer_view", 
     *                                      methods={"GET"}, 
     *                                      requirements={"id"="\d+", "page"="\d+"}, 
     *                                      defaults={"page"=1})
     */
    public function customerViewResume(Customer $customer, int $page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('La page '.$page.' n\'existe pas.');
        }

        $events = $this->getDoctrine()
                       ->getRepository(Event::class)
                       ->getEventsForCustomer($customer, $page, self::PAGINATION_EVENTS);
        
        $nbPages = ceil(count($customer) / self::PAGINATION_EVENTS);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        // Add comment form (sidebar)
        $form =  $this->createForm(CustomerCommentType::class);

        return $this->render('CRM/customer-view.html.twig', [
            'Customer' => $customer,
            'Events' => $events,
            'CustomerCommentForm' => $form->createView(),
            'NbPages'     => $nbPages,
            'Page'        => $page,
        ]);
    }

    /**
     * @Route("/crm/customers/{id}/detail", name="crm_customer_detail", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function customerUpdate(Request $request, Customer $customer)
    {
        $customerCommentForm =  $this->createForm(CustomerCommentType::class)->createView();
                
        $form =  $this->createForm(CustomerType::class, $customer)
                      ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()
                                  ->getManager();

            $entityManager->persist($customer);
            $entityManager->flush();

            $this->addFlash('success','Le client a bien été modifié !');

            return $this->redirectToRoute('crm_customer_detail', ['id' => $customer->getId()]);
        }

        return $this->render('CRM/customer-detail.html.twig', [
            'Customer' => $customer,
            'CustomerForm' => $form->createView(),
            'CustomerCommentForm' => $customerCommentForm,
            ]);
    }

    /**
     * @Route("/crm/customers/add", name="crm_customer_add", methods={"GET", "POST"})
     */
    public function customerAdd(Request $request)
    {
        $customer = new Customer();
        $form =  $this->createForm(CustomerType::class, $customer)
                      ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()
                                  ->getManager();

            $entityManager->persist($customer);
            $entityManager->flush();

            $this->addFlash('success','Le client a bien été ajouté !');

            return $this->redirectToRoute('crm_customer_detail', ['id' => $customer->getId()]);
        }

        return $this->render('CRM/customer-add.html.twig', [
            'CustomerForm' => $form->createView(),
            ]);
    }
    
    /**
     * @Route("/crm/customers/delete/{id}", name="crm_customer_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function customerDelete(Customer $customer)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($customer);
        $entityManager->flush();

        $this->addFlash('info','Le client / prospect a bien été supprimé.');
        
        return $this->redirectToRoute('crm_customer_list');
    }

    /**
     * @Route("/crm/customers/add-comment/{id}", name="crm_customer_add_comment", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function customerAddComment(Request $request, Customer $customer, EventCreator $eventCreator)
    {
        $customerComment = new CustomerComment();
        $form =  $this->createForm(CustomerCommentType::class, $customerComment)
                      ->handleRequest($request);
        
        if(!$form->isValid()){
            $this->addFlash('danger','Une erreur est survenue : '.$form->getErrors()[0]);
            return $this->redirectToRoute('crm_customer_view', ['id' => $customer->getId()]);
        }

        $eventCreator->setDescription($customerComment->getComment());
        $eventCreator->createEvent($customer, EventType::TYPE_COMMENT_ADD);
        $this->addFlash('success','Votre information a été ajoutée !');

        return $this->redirectToRoute('crm_customer_view', ['id' => $customer->getId()]);
    }

    /**
     * @Route("/crm/address-book/{page}", name="crm_addressbook", 
     *                                    requirements={"page"="\d+"},
     *                                    defaults={"page"=1},
     *                                    methods={"GET"})
     */
    public function addressBook(int $page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('La page '.$page.' n\'existe pas.');
          }

        $customers = $this->getDoctrine()
                          ->getRepository(Customer::class)
                          ->getAddressBookCustomers($page, self::PAGINATION_ADDRESSBOOK);

        $nbPages = ceil(count($customers) / self::PAGINATION_ADDRESSBOOK);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
  
        return $this->render('CRM/address-book.html.twig', [
            'Customers'   => $customers,
            'NbPages'     => $nbPages,
            'Page'        => $page,
            ]);
    }
}

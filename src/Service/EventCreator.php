<?php

namespace App\Service;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

use App\Entity\{EventType, Event, Customer, Quotation};

/**
 * Easy add event for a customer
 */
class EventCreator 
{
    private $doctrine;
    
    private $description;
    private $additionalInformation;

    private $quotation;


    public function __construct(Doctrine $doctrine){
        $this->doctrine = $doctrine;
    }

    public function createEvent(Customer $customer, string $eventTypeName){

        $eventType = $this->doctrine->getRepository(EventType::class)
                                    ->findOneByName($eventTypeName);

        if(!$eventType){
            throw new InvalidArgumentException($eventTypeName .' is not a valid EventType. @See EventType::TYPE_ const to know all valid EventType');
            exit();
        }

        if(!$this->isValidEvent($eventTypeName)){
            throw new InvalidArgumentException($eventTypeName .' need all information about event (Eg: setQuotation)');
            exit();
        }

        $event = new Event();
        $event->setType($eventType);
        $event->setCustomer($customer);
        $event->setAdditionalInformation($this->additionalInformation);

        if(!$this->description)
            $this->description = $this->getDescriptionForEventType($eventTypeName);

        $event->setDescription($this->description);

        $entityManager = $this->doctrine->getEntityManager();
        $entityManager->persist($event);
        $entityManager->flush();

        return true;
    }

    private function getDescriptionForEventType($eventTypeName){

        $eventDescription = [EventType::TYPE_QUOTATION_ADD => 'Devis ajouté !',
                             EventType::TYPE_QUOTATION_ACCEPT => 'Devis accepté !',
                             EventType::TYPE_CUSTOMER_ADD => 'Client ajouté !',
                            ];

        return $eventDescription[$eventTypeName];
    }

    private function isValidEvent($eventTypeName){
        if($eventTypeName == EventType::TYPE_QUOTATION_ADD OR $eventTypeName == EventType::TYPE_QUOTATION_ACCEPT) 
        {    
            if(!$this->quotation instanceof Quotation)
                return false;
        }
        return true;
    }
    
    public function setQuotation(Quotation $quotation){
        $this->quotation = $quotation;
        return $this;
    }

    public function setDescription(?string $description){
        $this->description = $description;
        return $this;
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Event;

class EventController extends AbstractController
{
    /**
     * @Route("/event/delete/{id}", name="event_delete", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function eventDelete(Event $event)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if(!$event->getType()->isRemovableByUser())
            throw $this->createNotFoundException("Cet évenement ne peut être supprimé");

        $entityManager->remove($event);
        $entityManager->flush();

        $this->addFlash('info','L\'élément a bien été supprimé.');
        
        return $this->redirectToRoute('crm_customer_view', ['id' => $event->getCustomer()->getId()]);
    }
}

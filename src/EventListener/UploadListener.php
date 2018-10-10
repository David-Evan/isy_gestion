<?php
namespace App\EventListener;

use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

use App\Entity\Customer;

/**
 * Upload Listener process upload files to put them on customer
 */
class UploadListener
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
     * @return string response for client
     * Using this method to return response to server when customer picture
     */
    public function onUpload(PostPersistEvent $event)
    {
        $response = $event->getResponse();
        $uploadFileURL = Customer::CUSTOMER_AVATAR_DIR .$event->getFile()->getFilename();

        // Get Customer id pass in hidden field
        $customerID = $_POST['_customer_ID'];

        $customer = $this->doctrine->getRepository(Customer::class)
                                   ->findOneById($customerID);
        if(!$customer){
            $response->setSuccess(false);
            $response->setError('Unknow customer');
            return $response;
        }

        $customer->setAvatarURL($uploadFileURL);

        $entityManager = $this->doctrine->getEntityManager();
        $entityManager->persist($customer);
        $entityManager->flush();

        // At this point, upload is done. Return avatar path for displaying new img
        $response['uploadFileURL'] = $uploadFileURL;

        return $response;
    }
}
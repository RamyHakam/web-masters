<?php

namespace App\Listeners;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class DatabaseActivitySubscriber  implements  EventSubscriberInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
            'postRemove',
        ];
    }

    public function postPersist(LifecycleEventArgs  $args)
    {
        $entity  = $args->getEntity();
        if(!$entity instanceof  User) {
            return;
        }
        $this->logActivity(sprintf('persist new entity of with id = %s',$args->getEntity()->getId() ));
    }

    public function postUpdate(LifecycleEventArgs  $args)
    {
        $this->logActivity(sprintf('Update  entity of with id =  %s',$args->getEntity()->getId() ));

    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->logActivity(sprintf(' remove   entity of with Id =  %s',$args->getEntity( )->getId()));

    }

    private function  logActivity(string $message)
    {
        $this->logger->info($message);
    }
}
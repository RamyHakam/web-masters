<?php

namespace App\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class LogListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function prePersist(LifecycleEventArgs $arg)
    {
        $this->logger->info('Entity persisted',['entityType' =>$arg->getEntity()]);
    }
}
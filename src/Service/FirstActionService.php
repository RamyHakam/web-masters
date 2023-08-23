<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class FirstActionService
{
    private LoggerInterface $logger;
    private Security $security;

    public function __construct(LoggerInterface $logger ,Security $security)
    {
        $this->logger = $logger;
        $this->security = $security;
    }

    public function logTheCurrentUser(): void
    {
        $this->logger->info('User is logged in from Service class with {email}', ['email' => $this->security->getUser()->getEmail()]);
    }
}
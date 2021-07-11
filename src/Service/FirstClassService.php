<?php


namespace App\Service;


use Psr\Log\LoggerInterface;

class FirstClassService
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private $services = [];

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param array $services
     */
    public function addService( $service): void
    {
        $this->services [] = $service;
    }
}
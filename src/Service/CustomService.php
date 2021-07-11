<?php


namespace App\Service;


use Psr\Log\LoggerInterface;

class CustomService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function getSomeDate()
    {
        $this->logger->info("create a new custom service from factory");
        return true;
    }
}
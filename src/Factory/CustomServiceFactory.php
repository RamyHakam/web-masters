<?php


namespace App\Factory;


use App\Service\CustomService;
use Psr\Log\LoggerInterface;

class CustomServiceFactory
{
    public function CreateNewCustomService(LoggerInterface $logger)
    {
        return new CustomService($logger);
    }
}
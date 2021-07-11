<?php


namespace App\Service;


use Psr\Log\LoggerInterface;

class RandomNumberService
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(LoggerInterface $logger,bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

    public function getRandomNumber(int $min,int $max): int
    {
        $number = random_int($min,$max);
        $this->logger->debug(sprintf("this is a random number inside service %s",$number));
        return $number;
    }
}
<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class MyOwnServiceLocator implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public static function getSubscribedServices()
    {
       return  [
            FirstActionService::class,
           SecondActionService::class,
           ThirdActionService::class
        ];
    }

    public function getAction(string $name)
    {
       return $this->locator->has($name)? $this->locator->get($name): null;
    }
}
<?php

namespace App\Service;

use App\Traits\FirstActionAware;
use App\Traits\SecondActionAware;
use App\Traits\ThirdActionAware;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

class MyOwnServiceLocator implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait ,FirstActionAware,SecondActionAware,ThirdActionAware;

    public function doAction(string $name)
    {
        switch ($name)
        {
            case FirstActionService::class:
                return $this->firstAction();
            case SecondActionService::class:
                return $this->secondAction();
            case ThirdActionService::class:
                return $this->thirdAction();
        }
    }
}
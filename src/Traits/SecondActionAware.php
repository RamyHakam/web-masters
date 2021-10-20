<?php

namespace App\Traits;

use App\Service\SecondActionService;

Trait SecondActionAware
{
    private function secondAction(): SecondActionService
    {
        return $this->container->get(__CLASS__."::".__FUNCTION__);
    }

}
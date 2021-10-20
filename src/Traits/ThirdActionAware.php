<?php

namespace App\Traits;

use App\Service\ThirdActionService;

trait ThirdActionAware
{
    private function thirdAction(): ThirdActionService
    {
        return $this->container->get(__CLASS__."::".__FUNCTION__);
    }
}
<?php

namespace App\Listeners;

use App\Entity\User;
use App\Service\EncryptPasswordService;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener
{
    private EncryptPasswordService $encryptPassword;

    public function __construct(EncryptPasswordService $encryptPassword)
    {
        $this->encryptPassword = $encryptPassword;
    }

    public function __invoke(User $user , LifecycleEventArgs  $args)
    {
        $user->setPassword($this->encryptPassword->encryptPassword($user->getPassword()));
    }
}
<?php

namespace App\Listeners;

use App\Entity\Main\Account;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class BlockedUserCheckSubscriber implements  EventSubscriberInterface
{

    public function onCheckPassport(CheckPassportEvent $event): void
    {
        /** @var Account $user */
        $user = $event->getPassport()->getUser();

        if($user->isBlocked()) {
            throw new  CustomUserMessageAuthenticationException('Your account is blocked' );
        }
    }
    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -100]
        ];
    }
}
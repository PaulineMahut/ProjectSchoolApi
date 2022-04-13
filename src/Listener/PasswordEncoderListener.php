<?php

namespace App\Listener;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderListener implements EventSubscriberInterface {

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder ) {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE],
        ];
    }

    public function encodePassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        if (!$user instanceof User) {
            return;
        }

        $passwordHash = $this->encoder->hashPassword($user, $user->getPassword());
        $user->setPassword($passwordHash);
    }
}
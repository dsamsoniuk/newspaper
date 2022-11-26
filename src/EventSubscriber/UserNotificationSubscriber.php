<?php

namespace App\EventSubscriber;

use App\Event\UserCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserNotificationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() : array{
        return [
            UserCreatedEvent::class => 'onUserAdded'
        ];
    }
    public function onUserAdded(UserCreatedEvent $event){
        $user = $event->getUser();

        // Send email for user
    }
}

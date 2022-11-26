<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event
{
    public function __construct(private User $user)
    {
    }
    public function getUser(){
        return $this->user;
    }
}

<?php

namespace App\Message;

class OrderConfirm
{
    public function __construct(private int $id) 
    {
    }
    public function getId(){
        return $this->id;
    }
}

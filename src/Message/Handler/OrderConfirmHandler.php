<?php

namespace App\Message\Handler;

use App\Message\OrderConfirm;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderConfirmHandler implements MessageHandlerInterface
{

    public function __invoke(OrderConfirm $order)
    {
        echo 'res:'.$order->getId();
    }
}

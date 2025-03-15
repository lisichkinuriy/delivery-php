<?php

namespace App\Domain\Services;

use App\Domain\Courier\Courier;
use App\Domain\Order\Order;

interface IOrderDispatcher
{
    /**
     * @param array<Courier> $couriers
     */
    function dispatch(Order $order, array $couriers): Courier;
}
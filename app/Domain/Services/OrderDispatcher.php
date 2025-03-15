<?php

namespace App\Domain\Services;

use App\Domain\Courier\Courier;
use App\Domain\Exceptions\LogicException;
use App\Domain\Order\Order;

final class OrderDispatcher implements IOrderDispatcher
{
    function dispatch(Order $order, array $couriers): Courier
    {
        $bestCourier = null;
        $minTime = PHP_FLOAT_MAX;

        foreach ($couriers as $courier) {
            $courierTime = $courier->calcTimeToLocation($order->getLocation());
            if ($courierTime < $minTime) {
                $minTime = $courierTime;
                $bestCourier = $courier;
            }
        }

        if(is_null($bestCourier)) {
            throw new LogicException('Best courier is null');
        }

        return $bestCourier;
    }
}
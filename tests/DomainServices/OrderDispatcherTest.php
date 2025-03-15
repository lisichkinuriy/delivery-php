<?php

namespace DomainServices;

use App\Domain\Courier\Courier;
use App\Domain\Courier\Transport;
use App\Domain\Order\Order;
use App\Domain\Services\OrderDispatcher;
use App\Domain\VO\CourierName;
use App\Domain\VO\Location;
use App\Domain\VO\OrderID;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OrderDispatcherTest extends TestCase
{
    public function test_order_dispatcher_can_dispatch()
    {
        $speed = new Speed(1);

        $c1 = new Courier(CourierName::fake(), new Location(1,1), TransportName::fake(), $speed);
        $c2 = new Courier(CourierName::fake(), new Location(2,2), TransportName::fake(), $speed);

        $order = new Order(OrderID::fake(), new Location(3,3));

        $dispatcher = new OrderDispatcher();
        $winner = $dispatcher->dispatch($order, [$c1, $c2]);

        $this->assertTrue($winner->equals($c2));
    }


}
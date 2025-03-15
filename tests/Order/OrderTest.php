<?php

namespace Order;

use App\Domain\Courier\Courier;
use App\Domain\Courier\Transport;
use App\Domain\Order\Order;
use App\Domain\VO\CourierName;
use App\Domain\VO\Location;
use App\Domain\VO\OrderID;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function test_order_create()
    {
        $orderID = OrderID::fake();
        $location = Location::fake();
        $order = new Order($orderID, $location);

        $this->assertTrue($orderID->equals($order->getId()));
        $this->assertTrue($location->equals($order->getLocation()));
        $this->assertTrue($order->isCreated());
        $this->assertNull($order->getCourierID());
    }


}
<?php

namespace Courier;

use App\Domain\Courier\Courier;
use App\Domain\Courier\Transport;
use App\Domain\VO\CourierName;
use App\Domain\VO\Location;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CourierTest extends TestCase
{
    public function test_courier_create()
    {
        $name = CourierName::fake();
        $location = Location::fake();
        $transportName = TransportName::fake();
        $speed = Speed::fake();
        $courier = new Courier($name, $location, $transportName, $speed);

        $this->assertEquals($name, $courier->getName());
        $this->assertEquals($location, $courier->getLocation());
        $this->assertEquals($transportName, $courier->getTransport()->getName());
        $this->assertEquals($speed, $courier->getTransport()->getSpeed());
    }

    public function test_courier_calc_time_to_location()
    {

        // Изначальная точка курьера: [1,1]
        // Целевая точка: [5,10]
        // Количество шагов, необходимое курьеру: 13 (4 по горизонтали и 9 по вертикали)
        // Скорость транспорта (велосипедиста): 2 шага в 1 такт
        // Время подлета: 13/2 = 6.5 тактов потребуется курьеру

        $speed = new Speed(2);
        $location = Location::minLocation();
        $courier = new Courier(CourierName::fake(), $location, TransportName::fake(), $speed);

        $target = new Location(5, 10);
        $time = $courier->calcTimeToLocation($target);

        $this->assertEquals(6.5, $time);
    }
}
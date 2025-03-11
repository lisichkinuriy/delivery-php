<?php

namespace Courier;

use App\Domain\Courier\Transport;
use App\Domain\VO\Location;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{

    static public function move(): array
    {
        $pedestrian = Transport::create(new TransportName("Pedestrian"), new Speed(1));
        $bicycle = Transport::create(new TransportName("bycicle"), new Speed(2));

        $location11 = new Location(1, 1);
        $location12 = new Location(1, 2);
        $location13 = new Location(1, 3);
        $location15 = new Location(1, 5);
        $location22 = new Location(2, 2);
        $location32 = new Location(3, 2);
        $location42 = new Location(4, 2);

        return [

            ["Pedestrian Same Location", $pedestrian, $location11, $location11, $location11],
            ["Pedestrian Move Up", $pedestrian, $location11, $location12, $location12],
            ["Pedestrian Move Up Limited", $pedestrian, $location11, $location15, $location12],
            ["Pedestrian Move Right", $pedestrian, $location22, $location32, $location32],
            ["Pedestrian Move Down", $pedestrian, $location12, $location11, $location11],
            ["Pedestrian Move Left", $pedestrian, $location22, $location12, $location12],

            // Велосипедист
            ["Bicycle Same Location", $bicycle, $location11, $location11, $location11],
            ["Bicycle Move Up", $bicycle, $location11, $location13, $location13],
            ["Bicycle Move Up Limited", $bicycle, $location11, $location15, $location13],
            ["Bicycle Move Right", $bicycle, $location22, $location42, $location42],
            ["Bicycle Move Down", $bicycle, $location13, $location11, $location11],
            ["Bicycle Move Left", $bicycle, $location32, $location12, $location12],

        ];
    }

    #[DataProvider("move")]
    public function test_transport_move(string $msg, Transport $transport, Location $from, Location $target, Location $expected)
    {
        $location = $transport->move($from, $target);
        $this->assertTrue($location->equals($expected));
    }
}
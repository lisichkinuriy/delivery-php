<?php

namespace VO;

use App\Domain\Exceptions\VOException;
use App\Domain\VO\Location;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function test_location_can_create()
    {
        $location = new Location(1, 10);
        $this->assertNotNull($location);
    }

    public static function distance(): array
    {
        return [
            [Location::MIN, Location::MIN, Location::MIN, Location::MIN, 0],
            [Location::MIN, Location::MIN, Location::MIN, Location::MAX, Location::MAX - 1],
            [Location::MIN, Location::MIN, Location::MIN + 3, Location::MIN + 2, 5],
        ];
    }

    #[DataProvider("distance")]
    public function test_location_can_calc_distance(int $x1, int $y1, int $x2, int $y2, int $expectedDistance)
    {
        $l1 = new Location($x1, $y1);
        $l2 = new Location($x2, $y2);
        $distance = Location::distance($l1, $l2);

        $this->assertEquals($distance, $expectedDistance);
    }


    public static function constraints(): array
    {
        return [
            [Location::MIN-1, Location::MIN],
            [Location::MAX+1, Location::MAX],
            [Location::MAX, Location::MAX+1],
            [Location::MAX, Location::MIN-1],
        ];
    }

    #[DataProvider("constraints")]
    public function test_location_constraints(int $x, int $y)
    {
        $this->expectException(VOException::class);
        $location = new Location($x, $y);
    }

    public function test_location_can_fake()
    {
        $location = Location::fake();
        $this->assertNotNull($location);
    }



}
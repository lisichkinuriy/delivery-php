<?php

namespace App\Domain\Courier;

use App\Domain\VO\Location;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;
use App\Utils\Math;
use Ramsey\Uuid\Uuid;

class Transport
{
    private function __construct(
        private string $id,
        private TransportName $name,
        private Speed $speed
    )
    {
    }

    static public function create(TransportName $name, Speed $speed): self
    {
        $uuid = Uuid::uuid4();
        return new self($uuid->toString(), $name, $speed);
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): TransportName {
        return $this->name;
    }

    public function getSpeed(): Speed {
        return $this->speed;
    }

    public function move(Location $current, Location $target): Location
    {
        if($current->equals($target)) {
            return $current;
        }

        $dx = $target->x - $current->x;
        $dy = $target->y - $current->y;

        $range = $this->speed->value;

        if(abs($dx) > $range) {
            $dx = Math::copysign($range, $dx);
        }
        $range -= abs($dx);

        if(abs($dy) > $range) {
            $dy = Math::copysign($range, $dy);
        }

        return new Location($current->x + $dx, $current->y + $dy);

    }
}
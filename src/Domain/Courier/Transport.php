<?php

namespace App\Domain\Courier;

use App\Domain\VO\Location;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportID;
use App\Domain\VO\TransportName;
use App\Utils\Math;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\Uuid;

#[Entity]
#[Table(name: 'transports')]
class Transport
{
    #[Id]
    #[Column(type: Types::GUID)]
    private string $id;
    #[Column(type: Types::STRING)]
    private string $name;
    #[Column(type: Types::INTEGER)]
    private int $speed;



    private function __construct(
        TransportID   $id,
        TransportName $name,
        Speed         $speed
    )
    {
        $this->id = $id->value;
        $this->name = $name->value;
        $this->speed = $speed->value;
    }

    public function equals(Transport $other): bool
    {
        return $this->getId()->equals($other->getId());
    }

    static public function create(TransportName $name, Speed $speed): self
    {
        return new self(TransportID::generate(), $name, $speed);
    }

    public function getId(): TransportID
    {
        return new TransportID($this->id);
    }

    public function getName(): TransportName
    {
        return new TransportName($this->name);
    }

    public function getSpeed(): Speed
    {
        return new Speed($this->speed);
    }

    public function move(Location $current, Location $target): Location
    {
        if ($current->equals($target)) {
            return $current;
        }

        $dx = $target->x - $current->x;
        $dy = $target->y - $current->y;

        $range = $this->speed;

        if (abs($dx) > $range) {
            $dx = Math::copysign($range, $dx);
        }
        $range -= abs($dx);

        if (abs($dy) > $range) {
            $dy = Math::copysign($range, $dy);
        }

        return new Location($current->x + $dx, $current->y + $dy);

    }
}
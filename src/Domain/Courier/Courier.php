<?php

namespace App\Domain\Courier;

use App\Domain\VO\CourierID;
use App\Domain\VO\CourierName;
use App\Domain\VO\CourierStatus;
use App\Domain\VO\Location;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

#[Entity]
#[Table(name: 'couriers')]
class Courier
{
    #[OneToOne(targetEntity: Transport::class, cascade: ['persist'], orphanRemoval: true)]
    private Transport $transport;
    #[Id]
    #[Column(type: Types::GUID, nullable: false)]
    private string $id;
    #[Column(type: Types::STRING, nullable: false, enumType: CourierStatus::class)]
    private CourierStatus $status;
    #[Column(type: Types::STRING, nullable: false)]
    private string $name;
    #[Column(type: Types::JSON, nullable: false)]
    private array    $location;

    public function __construct(
        CourierName $name,
        Location    $location,
        TransportName       $transportName,
        Speed               $speed
    )
    {
        $this->id = CourierID::generate()->value;
        $this->name = $name->value;
        $this->location = $location->toArray();
        $this->status = CourierStatus::FREE;
        $this->transport = Transport::create($transportName, $speed);
    }

    static public function createHobo(): self
    {
        return new self(
            new CourierName("John Doe"),
            Location::minLocation(),
            TransportName::pedestrian(),
            Speed::min());
    }

    public function equals(Courier $other): bool
    {
        return $this->getId()->equals($other->getId());
    }

    public function getName(): CourierName
    {
        return new CourierName($this->name);
    }

    public function getLocation(): Location
    {
        return Location::fromArray($this->location);
    }

    public function getTransport(): Transport
    {
        return $this->transport;
    }

    public function getId(): CourierID
    {
        return new CourierID($this->id);
    }

    public function setFree(): void
    {
        $this->status = CourierStatus::FREE;
    }

    public function isFree(): bool
    {
        return $this->status === CourierStatus::FREE;
    }

    public function setBusy(): void
    {
        $this->status = CourierStatus::BUSY;
    }

    public function isBusy(): bool
    {
        return $this->status === CourierStatus::BUSY;
    }

    public function calcTimeToLocation(Location $target): float
    {
        $distance = Location::distance($this->getLocation(), $target);

        $time = $distance*1.0 / $this->transport->getSpeed()->value;
        return $time;
    }

    public function move(Location $target): void
    {
        $new_location = $this->transport->move($this->getLocation(), $target);
        $this->location = $new_location->toArray();
    }


}
<?php

namespace App\Domain\Courier;

use App\Domain\VO\CourierID;
use App\Domain\VO\CourierName;
use App\Domain\VO\CourierStatus;
use App\Domain\VO\Location;
use App\Domain\VO\Speed;
use App\Domain\VO\TransportName;


final class Courier
{
    private Transport $transport;
    private CourierID $id;
    private CourierStatus $status;

    public function __construct(
        private CourierName $name,
        private Location    $location,
        TransportName       $transportName,
        Speed               $speed
    )
    {
        $this->status = CourierStatus::FREE;
        $this->id = CourierID::generate();
        $this->transport = Transport::create($transportName, $speed);
    }

    public function getName(): CourierName
    {
        return $this->name;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getTransport(): Transport
    {
        return $this->transport;
    }

    public function getId(): CourierID
    {
        return $this->id;
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
        $distance = Location::distance($this->location, $target);

        $time = $distance*1.0 / $this->transport->getSpeed()->value;
        return $time;
    }

    public function move(Location $target): void
    {
        $new_location = $this->transport->move($this->location, $target);
        $this->location = $new_location;
    }


}
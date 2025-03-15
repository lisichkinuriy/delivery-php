<?php

namespace App\Domain\Order;

use App\Domain\Courier\Courier;
use App\Domain\Exceptions\LogicException;
use App\Domain\VO\CourierID;
use App\Domain\VO\Location;
use App\Domain\VO\OrderID;
use App\Domain\VO\OrderStatus;

class Order
{
    private OrderStatus $status;
    private ?CourierID $courierID;

    public function __construct(
        private OrderID  $id,
        private Location $location)
    {
        $this->status = OrderStatus::CREATED;
        $this->courierID = null;
    }

    public function equals(Order $other): bool
    {
        return $this->getId()->equals($other->getId());
    }

    public function isComplete(): bool
    {
        return $this->status === OrderStatus::COMPLETED;
    }

    public function isAssigned(): bool
    {
        return $this->status === OrderStatus::ASSIGNED;
    }

    public function isCreated(): bool
    {
        return $this->status === OrderStatus::CREATED;
    }

    public function getCourierID(): ?CourierID
    {
        return $this->courierID;
    }

    public function getId(): OrderID
    {
        return $this->id;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function assign(Courier $courier): void
    {
        if($courier->isBusy()) {
            throw new LogicException("Courier is busy");
        }

        if(false === $this->isCreated()) {
            throw new LogicException("Courier is not created");
        }

        $this->status = OrderStatus::ASSIGNED;
        $this->courierID = $courier->getId();
    }

    public function complete(): void
    {
        if(false === $this->isAssigned()) {
            throw new LogicException("Courier is not assigned");
        }

        $this->status = OrderStatus::COMPLETED;
    }

}
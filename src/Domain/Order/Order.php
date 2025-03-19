<?php

namespace App\Domain\Order;

use App\Domain\Courier\Courier;
use App\Domain\Exceptions\LogicException;
use App\Domain\VO\CourierID;
use App\Domain\VO\Location;
use App\Domain\VO\OrderID;
use App\Domain\VO\OrderStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'orders')]
class Order
{
    #[Id]
    #[Column(type: Types::GUID, nullable: false)]
    private OrderID  $id;
    #[Column(type: Types::STRING, nullable: false, enumType: OrderStatus::class)]
    private OrderStatus $status;

    #[Embedded]
    private ?CourierID $courierID;

    #[Embedded(columnPrefix: false)]
    private Location $location;

    public function __construct(
        OrderID  $id,
        Location $location)
    {
        $this->id = $id;
        $this->location = $location;
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
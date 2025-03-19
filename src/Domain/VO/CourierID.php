<?php

namespace App\Domain\VO;

use App\Domain\Exceptions\VOException;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[Embeddable]
readonly final class CourierID
{
    public function __construct(
        #[Column(type: "string", nullable: true)]
        public string $value
    )
    {
        if(false === Uuid::isValid($value)) {
            throw new VOException("CourierID  is not valid");
        }
    }

    public function equals(CourierID $other): bool
    {
        return $this->value === $other->value;
    }

    static public function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    static public function fake(): self
    {
        return self::generate();
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
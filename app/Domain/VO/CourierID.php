<?php

namespace App\Domain\VO;

use App\Domain\Exceptions\VOException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly final class CourierID
{

    public function __construct(
        public string $value
    )
    {
        if(false === Uuid::isValid($value)) {
            throw new VOException("CourierID  is not valid");
        }
    }

    static public function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    static public function fake(): self
    {
        return self::generate();
    }
}
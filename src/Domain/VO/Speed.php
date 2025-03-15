<?php

namespace App\Domain\VO;

use App\Domain\Exceptions\VOException;

readonly final class Speed
{
    const MAX = 3;
    const MIN = 1;

    public function __construct(
        public int $value,
    )
    {
        if($value < self::MIN || $value > self::MAX) {
            throw new VOException("Speed must be between {self::MIN} and {self::MAX}");
        }
    }

    static public function fake(): Speed
    {
        return new self(random_int(self::MIN, self::MAX));
    }

    public static function min(): self
    {
        return new self(self::MIN);
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
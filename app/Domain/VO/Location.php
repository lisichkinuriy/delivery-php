<?php

namespace App\Domain\VO;

use App\Domain\Exceptions\VOException;

readonly final class Location
{
    const MAX = 10;
    const MIN = 1;

    public function __construct(
        public int $x,
        public int $y
    )
    {
        if($x < self::MIN || $x > self::MAX) {
            throw new VOException("x must be between {self::MIN} and {self::MAX}");
        }

        if($y < self::MIN || $y > self::MAX) {
            throw new VOException("y must be between {self::MIN} and {self::MAX}");
        }

    }

    public function equals(Location $other): bool
    {
        return $this->x === $other->x && $this->y === $other->y;
    }

    static public function fake(): Location
    {
        return new self(random_int(self::MIN, self::MAX), random_int(self::MIN, self::MAX));
    }

    static public function distance(Location $l1, Location $l2): int {
        return abs($l1->x - $l2->x) + abs($l1->y - $l2->y);
    }

}
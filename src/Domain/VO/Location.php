<?php

namespace App\Domain\VO;

use App\Domain\Exceptions\VOException;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
readonly final class Location
{
    const MAX = 10;
    const MIN = 1;

    const X = "x";
    const Y = "y";

    public function __construct(
        #[Column(type: "integer", nullable: true)]
        public int $x,
        #[Column(type: "integer", nullable: true)]
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

    static public function fake(): self
    {
        return new self(random_int(self::MIN, self::MAX), random_int(self::MIN, self::MAX));
    }

    static public function minLocation(): self
    {
        return new self(self::MIN, self::MIN);
    }

    static public function distance(Location $l1, Location $l2): int {
        return abs($l1->x - $l2->x) + abs($l1->y - $l2->y);
    }

    static public function fromArray(array $data): self
    {
        return new self($data[self::X], $data[self::Y]);
    }

    public function toArray(): array
    {
        return [
            self::X => $this->x,
            self::Y => $this->y
        ];
    }


}
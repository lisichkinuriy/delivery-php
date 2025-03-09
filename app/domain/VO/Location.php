<?php

readonly final class Location
{
    public function __construct(
        public int $x,
        public int $y
    )
    {
    }

    static public function fake(): Location
    {
        return new self(random_int(1, 10), random_int(1, 10));
    }

    static public function distance(Location $l1, Location $l2): int {
        return abs($l1->x - $l2->x) + abs($l1->y - $l2->y);
    }

}
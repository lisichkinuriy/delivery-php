<?php

namespace App\Domain\VO;

use App\Domain\Exceptions\VOException;

readonly final class CourierName
{
    public const MIN = 3;
    public const MAX = 20;

    public function __construct(
        public string $value
    )
    {
        $len = mb_strlen($value);
        if($len < self::MIN || $len > self::MAX) {
            throw new VOException("len must be between {self::MIN} and {self::MAX}");
        }
    }

    static public function fake(): CourierName
    {
        return new self("fake");
    }

}
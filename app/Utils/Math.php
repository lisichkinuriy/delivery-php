<?php

namespace App\Utils;

class Math
{
    static public function copysign(int $a, int $b): int
    {
        $res = abs($a);
        if($b < 0) {
            $res = -$res;
        }
        return $res;
    }
}
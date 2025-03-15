<?php

namespace App\Domain\VO;

enum CourierStatus: string
{
    case FREE = "free";
    case BUSY = "busy";
}

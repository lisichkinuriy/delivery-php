<?php

namespace App\Domain\VO;

use Override;

enum CourierStatus: string
{
    case FREE = "free";
    case BUSY = "busy";

}

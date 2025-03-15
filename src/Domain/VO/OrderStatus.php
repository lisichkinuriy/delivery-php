<?php

namespace App\Domain\VO;

enum OrderStatus: string
{
    case CREATED = "created";
    case ASSIGNED = "assigned";
    case COMPLETED = "completed";
}

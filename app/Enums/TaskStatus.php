<?php

namespace App\Enums;

enum TaskStatus:int
{
    case NOT_STARTED = 0;
    case PENDING = 1;
    case COMPLETED = 2;
}

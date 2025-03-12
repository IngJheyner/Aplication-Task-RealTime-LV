<?php

namespace App\Enums;

enum TaskPinnedStatus:int
{
    case NOT_PINNED_ON_DASHBOARD = 0;
    case PINNED_ON_DASHBOARD = 1;
}

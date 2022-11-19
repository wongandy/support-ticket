<?php

namespace App\Enums\Tickets;

enum Priorities: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
}
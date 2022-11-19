<?php

namespace App\Enums\Tickets;

enum Statuses: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
}
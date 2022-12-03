<?php

namespace App\Models;

use App\Scopes\TicketScope;
use Coderflex\LaravelTicket\Models\Ticket as ModelsTicket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends ModelsTicket
{
    use HasFactory;
    use TicketScope;

    protected $fillable = [
        'title',
        'message',
        'priority',
        'status',
        'assigned_to',
    ];
}

<?php

namespace App\Models;

use App\Scopes\TicketScope;
use Coderflex\LaravelTicket\Models\Ticket as ModelsTicket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'upload',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

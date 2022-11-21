<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalTickets = Ticket::total()->count();

        $openTickets = Ticket::open()->count();

        $closedTickets = Ticket::closed()->count();
        
        return view('dashboard', compact('totalTickets', 'openTickets', 'closedTickets'));
    }
}

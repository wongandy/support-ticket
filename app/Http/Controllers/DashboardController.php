<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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

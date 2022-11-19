<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $tickets = Ticket::with('user', 'assignedToUser', 'labels', 'categories')
            ->when(auth()->user()->isAgent(), function (Builder $query) {
                $query->whereassignedTo(auth()->id());
            })
            ->when(auth()->user()->isUser(), function (Builder $query) {
                $query->whereUserId(auth()->id());
            })
            ->latest()
            ->paginate();

        return view('tickets.index', compact('tickets'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $this->authorize('create', Ticket::class);

        $labels = Label::visible()->pluck('name', 'id');
        $categories = Category::visible()->pluck('name', 'id');
        $agents = User::agents()->pluck('name', 'id');

        return view('tickets.create', compact('labels', 'categories', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $this->authorize('create', Ticket::class);
        
        DB::transaction(function () use ($request) {
            $ticket = auth()->user()->tickets()->create($request->only('title', 'description', 'priority'));
            
            $ticket->labels()->attach($request->labels);
            $ticket->categories()->attach($request->categories);

            if ($request->assign_to) {
                $ticket->update([
                    'assigned_to' => $request->assign_to
                ]);
            }
        });

        return to_route('tickets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket): View
    {
        $this->authorize('update', $ticket);
        
        $labels = Label::visible()->pluck('name', 'id');
        $categories = Category::visible()->pluck('name', 'id');
        $agents = User::agents()->pluck('name', 'id');

        return view('tickets.edit', compact('ticket', 'labels', 'categories', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->only('title', 'description', 'status', 'priority'));
        $ticket->labels()->sync($request->labels);
        $ticket->categories()->sync($request->categories);

        if ($request->assign_to) {
            $ticket->update([
                'assigned_to' => $request->assign_to
            ]);
        }

        return to_route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return to_route('tickets.index');
    }
}

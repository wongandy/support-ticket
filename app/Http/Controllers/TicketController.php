<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Actions\UploadFileAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTicketRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\NotifyAgentOfAssignedTicketNotification;
use App\Notifications\NotifyAdminAboutUserCreatedTicketNotification;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $tickets = Ticket::with('user', 'assignedToUser', 'labels', 'categories')
            ->when($request->has('priority'), function (Builder $query) use ($request) {
                $query->where('priority', $request->priority);
            })
            ->when($request->has('status'), function (Builder $query) use ($request) {
                $query->where('status', $request->status);
            })
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
            $ticket = auth()->user()->tickets()->create($request->only('title', 'message', 'priority'));
            $ticket->attachLabels($request->labels);
            $ticket->attachCategories($request->categories);

            if ($request->has('upload')) {
                (new UploadFileAction())->execute($ticket, $request->upload);
            }
            
            if ($request->assigned_to) {
                $ticket->assignTo($request->assigned_to);

                User::find($request->assigned_to)->notify(new NotifyAgentOfAssignedTicketNotification($ticket));
            } else {
                User::admins()
                    ->each(fn ($user) => $user->notify(new NotifyAdminAboutUserCreatedTicketNotification(($ticket))));
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
        
        $ticket->update($request->only('title', 'message', 'status', 'priority', 'assigned_to'));
        $ticket->syncLabels($request->labels);
        $ticket->syncCategories($request->categories);
        
        if ($request->has('upload')) {
            (new UploadFileAction())->execute($ticket, $request->upload);
        }

        if ($ticket->wasChanged('assigned_to')) {
            User::find($request->assigned_to)->notify(new NotifyAgentOfAssignedTicketNotification($ticket));
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

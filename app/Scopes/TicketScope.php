<?php

namespace App\Scopes;

use App\Enums\Tickets\Statuses;
use Illuminate\Database\Eloquent\Builder;

trait TicketScope
{
    public function scopeOpen(Builder $builder): Builder
    {
        return $builder->when(auth()->user()->isAgent(), function (Builder $builder) {
            $builder->where('assigned_to', auth()->user()->id);
        })->where('status', Statuses::OPEN->value);
    }

    public function scopeClosed(Builder $builder): Builder
    {
        return $builder->when(auth()->user()->isAgent(), function (Builder $builder) {
            $builder->where('assigned_to', auth()->user()->id);
        })->where('status', Statuses::CLOSED->value);
    }

    public function scopeTotal(Builder $builder): Builder
    {
        return $builder->when(auth()->user()->isAgent(), function (Builder $builder) {
            $builder->where('assigned_to', auth()->user()->id);
        });
    }
}
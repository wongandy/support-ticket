<?php

namespace App\Concerns;

use App\Enums\Tickets\Visibility;
use Illuminate\Database\Eloquent\Builder;

trait HasVisibility
{
    public function scopeVisible(Builder $builder)
    {
        return $builder->where('is_visible', Visibility::VISIBLE->value);
    }

    public function scopeHidden(Builder $builder)
    {
        return $builder->where('is_visible', Visibility::HIDDEN->value);
    }
}
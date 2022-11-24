<?php

namespace App\Scopes;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

trait UserScope
{
    public function scopeAdmins(Builder $builder)
    {
        return $builder->where('role_id', Role::ADMIN_ID);
    }

    public function scopeAgents($query)
    {
        return $query->where('role_id', Role::AGENT_ID);
    }
}
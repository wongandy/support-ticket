<?php

namespace App\Traits;

use App\Models\Role;

trait RoleTrait
{
    public function isAdmin(): bool
    {
        return $this->role_id == Role::ADMIN_ID;
    }

    public function isAgent(): bool
    {
        return $this->role_id == Role::AGENT_ID;
    }

    public function isUser(): bool
    {
        return $this->role_id == Role::USER_ID;
    }

    public function hasRole($role)
    {
        $roles = is_array($role)
            ? $role
            : array($role);

        if (! in_array($this->role->name, $roles)) {
            return false;
        }
        
        return true;
    }
}
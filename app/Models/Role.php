<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public const ADMIN_ID = 1;
    public const USER_ID = 2;
    public const AGENT_ID = 3;
}

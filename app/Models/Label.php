<?php

namespace App\Models;

use App\Concerns\HasVisibility;
use Coderflex\LaravelTicket\Models\Label as ModelsLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends ModelsLabel
{
    use HasFactory;
    use HasVisibility;

    protected $fillable = ['name', 'slug', 'is_visible'];
}

<?php

namespace App\Models;

use App\Concerns\HasVisibility;
use Coderflex\LaravelTicket\Models\Category as ModelsCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends ModelsCategory
{
    use HasFactory;
    use HasVisibility;

    protected $fillable = ['name', 'slug', 'is_visible'];
}

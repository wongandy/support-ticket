<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_visible'];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
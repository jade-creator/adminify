<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 * 
 * @property string $name
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}

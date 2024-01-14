<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 * 
 * @property string $name
 * @property string $category
 * @property string $description
 * @property \Carbon\Carbon $date_and_time
 * 
 * @property-read \App\Models\Category|null $category
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'date_and_time'
    ];

    protected $casts = [
        'date_and_time' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

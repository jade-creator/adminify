<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
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

    public function registerMediaCollections(): void
    {
        $acceptedImageMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        $this->addMediaCollection('images')
            ->acceptsMimeTypes($acceptedImageMimeTypes);
    }
}

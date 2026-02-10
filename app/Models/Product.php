<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,HasSlug;

    protected $table = 'products';

    protected $fillable = ['name', 'quantity', 'price'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSLugsFrom('name')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs(false)
            ->slugsShouldBeNoLongerThan(50);
    }

}

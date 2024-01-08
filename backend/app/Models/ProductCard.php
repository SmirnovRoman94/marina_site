<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductCard extends Model implements HasMedia
{
    use HasFactory;
    protected $guarded = false;
    use InteractsWithMedia;

    public function images()
    {
        return $this->getMedia('images');
    }
}

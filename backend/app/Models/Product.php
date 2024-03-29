<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;

    protected $guarded = false;
    use InteractsWithMedia;

    public function countProduct()
    {
        return PatientService::where('item_id', $this->id)->value('count');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Diplom extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = false;
    use InteractsWithMedia;
}

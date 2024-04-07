<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class PatientService extends Model
{
    use HasFactory;
    protected $guarded = false;
    use InteractsWithMedia;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = false;
    use InteractsWithMedia;

    public function countService()
    {
        return PatientService::where('item_id', $this->id)->value('count');
    }
}

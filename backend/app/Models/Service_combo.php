<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service_combo extends Model implements HasMedia
{
    use HasFactory;
    protected $guarded = false;
    use InteractsWithMedia;


    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_service_combos', 'combo_id', 'service_id')->withPivot('count');;
    }

    public function resultPrice()
    {
        return $this->old_price-(($this->old_price*$this->discount)/100);
    }

    public function сountCombo()
    {
        return PatientService::where('item_id', $this->id)->value('count');
    }
}

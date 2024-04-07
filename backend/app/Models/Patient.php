<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(PatientService::class, 'patient_id')->where('item_type', 'Service')->where('public', true);
    }

    public function serviceCombos()
    {
        return $this->hasMany(PatientService::class, 'patient_id')->where('item_type', 'Service_combo')->where('public', true);
    }

    public function products()
    {
        return $this->hasMany(PatientService::class, 'patient_id')->where('item_type', 'Product')->where('public', true);
    }
}

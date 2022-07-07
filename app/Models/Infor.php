<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infor extends Model
{
    public $timestamps = true;

    protected $fillable = ['device_id', 'turbidity', 'ph', 'wqi', 'temperature', 'do', 'bod5', 'cod', 'nh4', 'po4', 'tss', 'coliform', 'bod'];

    public function devices()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}

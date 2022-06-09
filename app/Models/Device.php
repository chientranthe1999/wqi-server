<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $timestamps = true;

    protected $fillable = ['name', 'type', 'lat', 'lon', 'location'];

    public function infors()
    {
        return $this->hasMany(Infor::class);
    }

}

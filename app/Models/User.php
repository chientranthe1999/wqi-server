<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;

    protected $fillable = ['name', 'phone', 'email', 'password'];

    public function articles() {
        return $this->hasMany(Article::Class);
    }
}

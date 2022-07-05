<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    public $timestamps = true;

    protected $fillable = ['user_id', 'content', 'category', 'title', 'image'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

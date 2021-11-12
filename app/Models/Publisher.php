<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'phone', 'url',
    ];

    public function book(){
        return $this->hasMany('App\Models\Book');
    }
}
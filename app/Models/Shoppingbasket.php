<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppingbasket extends Model
{
    use HasFactory;

//    protected $table = 'shoppingbaskets';

    public function customers(){
        return $this->hasOne('App\Models\Customer');
    }

    public function Books()
    {
        return $this->belongsToMany(Book::class);
    }
}

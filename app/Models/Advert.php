<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    public $timestamps = false;
    protected $fillable = ['image'];
}

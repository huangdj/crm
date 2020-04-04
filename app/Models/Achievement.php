<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['user_id', 'start', 'end', 'percent'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['userId', 'timeResult', 'userCheckTime', 'sourceType'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'userId', 'id');
    }
}

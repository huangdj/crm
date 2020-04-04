<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = ['user_id', 'base_salary', 'task', 'total_hours', 'amount'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

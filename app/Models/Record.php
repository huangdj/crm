<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['user_id', 'customer_id', 'buy_course_id', 'relation_course_id', 'buy_type_id', 'relation_type_id', 'surplus_hour'];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'buy_course_id', 'id');
    }

    public function relation_course()
    {
        return $this->belongsTo('App\Models\Course', 'relation_course_id', 'id');
    }

    public function hour()
    {
        return $this->belongsTo('App\Models\Hour');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

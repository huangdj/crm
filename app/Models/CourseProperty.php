<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProperty extends Model
{
    protected $table = 'course_properties';
    public $timestamps = false;
    protected $fillable = ['customer_id', 'course_id', 'c_hour', 'c_price', 'paid_at'];

    // 设置paid_at字段为时间
    protected $dates = [
        'paid_at',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

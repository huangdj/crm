<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationProperty extends Model
{
    protected $table = 'relation_properties';
    public $timestamps = false;
    protected $fillable = ['customer_id', 'course_id', 'g_hour', 'paid_at'];

    // 设置paid_at字段为时间
    protected $dates = [
        'paid_at',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

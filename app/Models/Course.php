<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'image'];

    public function customers()
    {
        return $this->belongsToMany('App\Models\Customer');
    }

    public function hours()
    {
        return $this->hasMany('App\Models\Hour');
    }

    static function all_courses()
    {
        $courses = self::orderBy('created_at', 'desc')->get();
        foreach ($courses as $k => $v) {
            $hour_price = Hour::where('course_id', $v['id'])->sum('price'); // 总价格
            $hour_count = Hour::where('course_id', $v['id'])->count(); // 总课时
            $hours = Hour::where('course_id', $v['id'])->get();  // 每个课程对应的所有课时
            $courses[$k]['hour_price'] = $hour_price;
            $courses[$k]['hour_count'] = $hour_count;
            $courses[$k]['hours'] = $hours;
        }
        return $courses;
    }


}

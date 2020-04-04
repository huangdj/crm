<?php

namespace App\Models;

use App\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $fillable = [
        'user_id', 'username', 'mobile', 'birthday', 'cycle_id', 'expired_at', 'card_price', 'card_at', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 每个会员有多种类型
    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    // 每个用户可以购买很多课程
    public function course_properties()
    {
        return $this->hasMany('App\Models\CourseProperty');
    }

    // 每个用户可以赠送很多课程
    public function relation_properties()
    {
        return $this->hasMany('App\Models\RelationProperty');
    }


}

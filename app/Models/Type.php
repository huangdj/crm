<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['type_name'];
    public $timestamps = false;

    // 每种类型有多个会员
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
}

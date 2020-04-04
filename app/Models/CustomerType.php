<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $table = 'customer_type';
    public $timestamps = false;
    protected $fillable = ['type_id', 'customer_id'];
}

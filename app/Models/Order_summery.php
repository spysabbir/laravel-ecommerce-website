<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_summery extends Model
{
    protected $guarded = [];

    use HasFactory;
    function relationtoproduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    function relationtocolor(){
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
    function relationtosize(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
    function relationtouser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

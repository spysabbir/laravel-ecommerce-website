<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Flashsale extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'flashsale_products');
    }
}

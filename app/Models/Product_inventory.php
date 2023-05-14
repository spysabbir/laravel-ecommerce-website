<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_inventory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    function relationtocategory(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    function relationtosubcategory(){
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }
    function relationtochildcategory(){
        return $this->hasOne(Childcategory::class, 'id', 'childcategory_id');
    }
    function relationtobrand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    function relationtocolor(){
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
    function relationtosize(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product_featured_photo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
}

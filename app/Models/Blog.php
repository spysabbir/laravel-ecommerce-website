<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    function relationtoblogcategory(){
        return $this->hasOne(Blog_category::class, 'id', 'blog_category_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCourse extends Model
{
    public function category()
    {
        return $this->belongsTo(CourseCategory::class,'cat_id');
    }
}

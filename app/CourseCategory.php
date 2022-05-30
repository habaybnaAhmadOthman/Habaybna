<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    public function contents()
    {
        return $this->belongsToMany(NewContent::class,'articles_tags');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewContent extends Model
{
    protected $table = 'contents';

    public function author()
    {
        return $this->hasOne(User::class,'author_id');
    }

    public function intrests()
    {
        return $this->belongsToMany(CourseCategory::class,'articles_tags');
    }
}

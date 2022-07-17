<?php

namespace App;
use Carbon;
use Illuminate\Database\Eloquent\Model;

class NewContent extends Model
{
    protected $table = 'contents';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];


    public function author()
    {
        return $this->belongsTo(Specialist::class,'author_id','user_id');
    }

    public function intrests()
    {
        return $this->belongsToMany(CourseCategory::class,'articles_tags','article_id','tag_id');
    }

    // public function isLiked()
    // {
    //     return $this->belongsTo();
    // }
}


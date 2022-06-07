<?php

namespace App;
use Carbon;
use Illuminate\Database\Eloquent\Model;

class NewContent extends Model
{
    protected $table = 'contents';

    public function setDateAttribute( $value ) {
        $this->attributes['date'] = (new Carbon($value))->format('d/m/y');
      }

    public function author()
    {
        return $this->belongsTo(Specialist::class,'author_id','user_id');
    }

    public function intrests()
    {
        return $this->belongsToMany(CourseCategory::class,'articles_tags','article_id','tag_id');
    }
}


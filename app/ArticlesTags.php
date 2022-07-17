<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticlesTags extends Model
{
    protected $fillable = ['tag_id','article_id'];


    public function article()
    {
        return $this->belongsTo(NewContent::class,'article_id' ,'id');
    }
}

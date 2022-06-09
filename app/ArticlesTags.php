<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticlesTags extends Model
{
    protected $fillable = ['tag_id','article_id'];
}

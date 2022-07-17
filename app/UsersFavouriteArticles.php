<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersFavouriteArticles extends Model
{
    protected $fillable = ['user_id'];

    public function articles()
    {
        return $this->belongsTo(NewContent::class,'article_id');
    }
}

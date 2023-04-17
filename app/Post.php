<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Post extends Model
{
    protected $guarded=[];
    protected $with = ['comments'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getCreatedAtAttribute()
    {
        return Carbon::create($this->attributes['created_at'])->locale('ar')->diffForHumans();
        // return  $created_at->diffForHumans();

    }
}

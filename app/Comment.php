<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;



class Comment extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $with = ['user'];

    // protected static function booted()
    // {
    //     static::addGlobalScope('users', function (Builder $builder) {
    //         $builder->where('status', true);
    //     });
    // }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::create($this->attributes['created_at'])->locale('ar')->diffForHumans();
        // return  $created_at->diffForHumans();

    }
}
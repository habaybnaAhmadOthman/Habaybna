<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id','status','title','points'];

    public function answers()
    {
        return $this->hasMany(Answer::class,'question_id');
    }

    public function getCorrectAnswerAttribute()
    {
        foreach($this->answers as $answer){
            if($answer->is_correct) {
                return $answer;
            }
            return false;
        }
    }
}

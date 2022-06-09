<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateLogos extends Model
{
    protected $fillable = ['course_id','url'];
    
    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
}

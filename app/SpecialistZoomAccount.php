<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialistZoomAccount extends Model
{
    protected $table = 'specialist_zoom_account';

    protected $fillable = ['spec_id','password','meeting_id','zoom_link','status'];

    
}

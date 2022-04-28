<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
   protected $table = 'old_content';
   protected $primaryKey = 'nid';
   public $timestamps = false;

}

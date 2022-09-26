<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirthdayGift extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loginfo extends Model
{
    protected $fillable=['user_id','detail','table','url'];
}

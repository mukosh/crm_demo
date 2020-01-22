<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    protected $fillable = [
         'client_id','login_id', 'title','original_name','status'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    protected $fillable = [
         'client_id','phonebook_name','login_id','created_at'
    ];
}

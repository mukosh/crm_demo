<?php
// namespace App;

// use Illuminate\Database\Eloquent\Model;

// class User extends Model
// {
//     protected $fillable = [
//         'name', 'email', 'password'
//     ];
// }




namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       // 'fname','lname', 'email', 'company', 'call_limit', 'pacing', 'password', 'phone', 'description', 'address', 'pincode', 'city', 'country', 'state',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}


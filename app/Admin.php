<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use SoftDeletes, HasApiTokens;
    use Notifiable, HasRoles;

    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'type', 'password',
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


//    Spatie Roles / Permissions
    protected $guard_name = 'admin';


    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}

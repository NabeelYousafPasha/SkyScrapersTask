<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Blogger extends Model
{
    use HasApiTokens, SoftDeletes, Notifiable, HasRoles;

    protected $guard = 'blogger';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    protected $guard_name = 'blogger';




//    accessors & mutators
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }


//    functions relationships

    /*
     * Blogger =>  hasMany  => Blog
     */
    public function blogger_blogs()
    {
        return $this->hasMany('App\Blog', 'fk_blogger_id', 'id');
    }
}

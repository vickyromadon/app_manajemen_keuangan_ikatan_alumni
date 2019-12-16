<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
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
     * Get the dataset that owns the user.
     */
    public function dataset()
    {
        return $this->hasOne('App\Models\Dataset');
    }

    /**
     * Get the news that owns the user.
     */
    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    /**
     * Get the galeries that owns the user.
     */
    public function galeries()
    {
        return $this->hasMany('App\Models\Galery');
    }

    /**
     * Get the event that owns the user.
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    /**
     * Get the message that owns the user.
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    /**
     * Get the donations that owns the user.
     */
    public function donations()
    {
        return $this->hasMany('App\Models\Donation');
    }
}

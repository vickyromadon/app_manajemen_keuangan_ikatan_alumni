<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number', 'owner'];

    /**
     * Get the dana_events that owns the bank.
     */
    public function dana_events()
    {
        return $this->hasMany('App\Models\DanaEvent');
    }
}

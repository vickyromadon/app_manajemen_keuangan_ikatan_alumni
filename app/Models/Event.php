<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'description', 'date', 'user_id', 'total_dana', 'total_contribution'
    ];

    /**
     * Get the user for the event.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the dana_events that owns the event.
     */
    public function dana_events()
    {
        return $this->hasMany('App\Models\DanaEvent');
    }
}

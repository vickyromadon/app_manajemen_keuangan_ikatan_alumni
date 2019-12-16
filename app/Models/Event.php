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
        'title', 'image', 'description', 'date', 'user_id'
    ];

    /**
     * Get the user for the event.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

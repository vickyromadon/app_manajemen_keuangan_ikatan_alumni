<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'description', 'user_id'
    ];

    /**
     * Get the users for the galery.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

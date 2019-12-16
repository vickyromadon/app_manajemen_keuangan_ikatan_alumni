<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    /**
     * Get the users for the news.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

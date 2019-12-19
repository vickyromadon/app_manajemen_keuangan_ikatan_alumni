<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'open_date', 'close_date', 'status', 'user_id'
    ];

    /**
     * Get the user for the contribution.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the dana_contributions that owns the contribution.
     */
    public function dana_contributions()
    {
        return $this->hasMany('App\Models\DanaContribution');
    }
}

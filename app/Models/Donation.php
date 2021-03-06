<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'description', 'donation_limit', 'link_video', 'user_id', 'total_dana', 'total_contribution'
    ];

    /**
     * Get the user for the event.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the dana_donations that owns the donation.
     */
    public function dana_donations()
    {
        return $this->hasMany('App\Models\DanaDonation');
    }
}

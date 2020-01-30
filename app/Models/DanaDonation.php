<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanaDonation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal', 'transfer_date', 'proof',
        'description', 'status', 'user_id',
        'bank_id', 'donation_id', 'code'
    ];

    /**
     * Get the user for the dana donation.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the bank for the dana donation.
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    /**
     * Get the donation for the dana donation.
     */
    public function donation()
    {
        return $this->belongsTo('App\Models\Donation');
    }

    /**
     * Get the income_reports that owns the dana donation.
     */
    public function income_reports()
    {
        return $this->hasMany('App\Models\IncomeReport');
    }
}

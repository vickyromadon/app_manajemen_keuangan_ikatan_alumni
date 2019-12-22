<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_date', 'type', 'nominal', 'description',
        'dana_donation_id', 'dana_event_id', 'dana_contribution_id',
        'user_id', 'bank_id'
    ];

    /**
     * Get the dana_donation for the income report.
     */
    public function dana_donation()
    {
        return $this->belongsTo('App\Models\DanaDonation');
    }

    /**
     * Get the dana_event for the income report.
     */
    public function dana_event()
    {
        return $this->belongsTo('App\Models\DanaEvent');
    }

    /**
     * Get the dana_contribution for the income report.
     */
    public function dana_contribution()
    {
        return $this->belongsTo('App\Models\DanaContribution');
    }

    /**
     * Get the user for the income report.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the bank for the income report.
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
}

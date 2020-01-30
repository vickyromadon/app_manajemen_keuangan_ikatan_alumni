<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanaEvent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal', 'transfer_date', 'proof',
        'description', 'status', 'user_id',
        'bank_id', 'event_id', 'code'
    ];

    /**
     * Get the user for the dana event.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the bank for the dana event.
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    /**
     * Get the event for the dana event.
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    /**
     * Get the income_reports that owns the dana event.
     */
    public function income_reports()
    {
        return $this->hasMany('App\Models\IncomeReport');
    }
}

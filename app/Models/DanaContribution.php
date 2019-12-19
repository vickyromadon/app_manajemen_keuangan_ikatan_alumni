<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanaContribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal', 'transfer_date', 'proof',
        'description', 'status', 'user_id',
        'bank_id', 'contribution_id'
    ];

    /**
     * Get the user for the dana contribution.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the bank for the dana contribution.
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    /**
     * Get the contribution for the dana contribution.
     */
    public function contribution()
    {
        return $this->belongsTo('App\Models\Contribution');
    }
}

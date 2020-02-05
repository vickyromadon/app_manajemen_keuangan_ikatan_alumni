<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_date', 'type', 'nominal', 'description', 'receiver',
        'bank_name', 'bank_number', 'bank_owner', 'sender', 'code'
    ];
}

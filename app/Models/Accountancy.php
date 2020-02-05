<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accountancy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'date', 'income', 'expense', 'total', 'type'];
}

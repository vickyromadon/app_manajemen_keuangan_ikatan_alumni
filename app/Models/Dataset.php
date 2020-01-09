<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis', 'fullname', 'parent_name',
        'birthdate', 'birthplace',
        'entrydate', 'outdate', 'status', 'department'
    ];

    /**
    * Get the users for the dataset.
    */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}

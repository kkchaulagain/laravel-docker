<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Account extends Model
{
    protected $collection = 'accounts';
    protected $fillable = [
        'name',
        "min_balance",
        'interest_rate',
        'status',
    ];

 
}

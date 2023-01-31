<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Project extends Model
{
    protected $collection = 'contacts';
    protected $fillable = [
        'customer_id',
        "type",
        'value',
        'is_verified',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

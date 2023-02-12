<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Application extends Model
{
    protected $collection = 'applications';


    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function basicInfo()
    {
        return $this->hasOne(BasicInfo::class);
    }
}

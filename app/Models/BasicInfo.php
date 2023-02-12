<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class BasicInfo extends Model
{
    protected $collection = 'basic_infos';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}

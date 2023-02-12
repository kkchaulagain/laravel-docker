<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class File extends Model
{
    protected $collection = 'files';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}

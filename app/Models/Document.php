<?php 

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Document extends Model
{
    protected $collection = 'documents';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
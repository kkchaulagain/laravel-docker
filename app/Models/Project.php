<?php 

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Project extends Model{
    protected $collection = 'projects';
    protected $fillable = [
        'business_id',
        "name",
        'description',
        'status',
    ];

    public function builds()
    {
        return $this->hasMany(Build::class, 'project_id');
    }
}
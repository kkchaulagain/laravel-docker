<?php 

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Build extends Model{
    protected $collection = 'builds';
    protected $fillable = [
        'project_id',
        "name",
        'description',
        'requirements',
        'schema',
        'status',
    ];

    public function project()
    {
        return $this->hasMany(Project::class, 'project_id');
    }
}
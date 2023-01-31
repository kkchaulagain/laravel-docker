<?php

namespace App\Services\Project;

use App\Filters\ProjectFilter;
use App\Models\Project;
use App\Services\BaseDatabaseService;

class ProjectService extends BaseDatabaseService
{

    public $model = Project::class;
    public $filterObject = ProjectFilter::class;
}



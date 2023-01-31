<?php

namespace App\Services\Project;

use App\Filters\BuildFilter;
use App\Filters\ProjectFilter;
use App\Models\Build;
use App\Models\Project;
use App\Services\BaseDatabaseService;

class BuildService extends BaseDatabaseService
{

    public $model = Build::class;
    public $filterObject = BuildFilter::class;
}



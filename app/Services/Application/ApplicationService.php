<?php

namespace App\Services\Application;

use App\Filters\ApplicationFilter;
use App\Models\Application;
use App\Services\BaseDatabaseService;

class ApplicationService extends BaseDatabaseService
{

    public $model = Application::class;
    public $filterObject = ApplicationFilter::class;
}

<?php

namespace App\Services\Application;

use App\Filters\BasicInfoFilter;
use App\Models\BasicInfo;
use App\Services\BaseDatabaseService;

class BasicInfoService extends BaseDatabaseService
{

    public $model = BasicInfo::class;
    public $filterObject = BasicInfoFilter::class;
}

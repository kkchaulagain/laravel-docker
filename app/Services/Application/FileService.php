<?php

namespace App\Services\Application;

use App\Filters\FileFilter;
use App\Models\File;
use App\Services\BaseDatabaseService;

class FileService extends BaseDatabaseService
{

    public $model = File::class;
    public $filterObject = FileFilter::class;
}

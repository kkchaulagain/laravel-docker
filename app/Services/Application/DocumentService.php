<?php

namespace App\Services\Application;

use App\Filters\DocumentFilter;
use App\Models\Document;
use App\Services\BaseDatabaseService;

class DocumentService extends BaseDatabaseService
{

    public $model = Document::class;
    public $filterObject = DocumentFilter::class;
}

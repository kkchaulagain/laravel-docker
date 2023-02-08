<?php

namespace App\Http\Controllers;

use App\Services\Project\BuildService;
use Illuminate\Http\Request;

class FacerecognitionController extends BaseController
{

    public $service;

    public function __construct(BuildService $service)
    {
        parent::__construct($service);
    }
}

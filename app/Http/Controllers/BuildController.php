<?php

namespace App\Http\Controllers;

use App\Services\Project\BuildService;
use Illuminate\Http\Request;

class BuildController extends BaseController
{

    public $service;

    public function __construct(BuildService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'project_id' => 'required|exists:projects,id',
            ]);

            return Parent::store($request);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'project_id' => 'exists:projects,id',
            ]);

            return Parent::update($request, $id);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

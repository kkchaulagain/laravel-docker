<?php

namespace App\Http\Controllers;

use App\Library\OpenAi\ProjectManager;
use App\Queue\RequirementQueue;
use App\Queue\SchemaQueue;
use App\Services\Project\BuildService;
use App\Services\Project\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{

    public $service;

    public function __construct(ProjectService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'business_id' => 'required'
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
                'name' => 'required',
                'description' => 'required',
            ]);

            return Parent::update($request, $id);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function generateRequirement($id)
    {
        try {
            $project = $this->service->find($id);
            if ($project) {
                $build = (new BuildService())->filterArray([
                    'project_id' => $id,
                    'status' => 0
                ])->latest()->first();
                if (!$build) {
                    $build = (new BuildService)->store([
                        'project_id' => $id,
                        'name' => $project->name,
                        'description' => $project->description,
                        'status' => 0
                    ]);
                }

                RequirementQueue::dispatch($build->id)->onQueue('requirement');

                return $this->successResponse($build);
            }
            return $this->errorResponse("Build not found", 404);
        } catch (\Exception $e) {
            dd($e);
            return $this->handleError($e);
        }
    }


    public function generateSchema($id)
    {
        try {
            $project = $this->service->find($id);
            if ($project) {
                $build = (new BuildService())->filterArray([
                    'project_id' => $id,
                    'status' => 0
                ])->latest()->first();
                if (!$build) {
                    throw new \Exception("Build not found", 404);
                }

                SchemaQueue::dispatch($build->id)->onQueue('schema');

                return $this->successResponse($build);
            }
            return $this->errorResponse("Build not found", 404);
        } catch (\Exception $e) {
            dd($e);
            return $this->handleError($e);
        }
    }

    public function select($id)
    {
        try {
            $project = $this->service->find($id);
            $build = (new BuildService())->filterArray([
                'project_id' => $id,
                'status' => 0
            ])->latest()->first();
            if (!$build) {
                throw new \Exception("Build not found", 404);
            }
            $project['build'] = $build;
            return $this->successResponse($project);
        } catch (\Exception $e) {
            dd($e);
            return $this->handleError($e);
        }
    }
}

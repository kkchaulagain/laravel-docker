<?php

namespace App\Http\Controllers;

use App\Library\OpenAi\ProjectManager;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    //

    public function generateRequirement(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
            ]);
            // $data = [
            //     'name' => 'Human Resource Management System',
            //     'description' => 'This is a system that manages human resources'
            // ];
            $requirement = new ProjectManager();
            $response = $requirement->generateRequirement($request->all());
            $data = [
                'output' => $response->getOutput(),
                'usage' => $response->getUsage(),
                'model' => $response->getModel(),
                'configuration' => $requirement->configuration,
                'json'=>$response->getJson()
            ];
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function generateSchema(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'requirement'=>'required|array'
            ]);
            // $data = [
            //     'name' => 'Human Resource Management System',
            //     'description' => 'This is a system that manages human resources'
            // ];
            $requirement = new ProjectManager();
            $response = $requirement->generateProjectSchema($request->all());
            $data = [
                'output' => $response->getOutput(),
                'usage' => $response->getUsage(),
                'model' => $response->getModel(),
                'configuration' => $requirement->configuration,
                'json'=>$response->getJson()
            ];
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

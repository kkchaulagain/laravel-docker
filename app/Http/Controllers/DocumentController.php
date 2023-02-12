<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Application\DocumentService;

class DocumentController extends BaseController
{

    public $service;

    public function __construct(DocumentService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'application_id' => 'required|exists:applications,_id',
                'type' => 'required|string|in:passport,driver_license,citizenship,Other',
                'number' => 'required|requiredif:type,passport,driver_license,citizenship',
                'issue_date' => 'date|requiredif:type,passport,driver_license,citizenship',
                'issue_district' => 'required|string|requiredif:type,passport,driver_license,citizenship',
                'is_verified' => 'boolean',
            ]);
            $data = $request->all();
            // check if is_verified is true
            if (!isset($request->is_verified)) {
                $data['is_verified'] = false;
            }
            $project = $this->service->store($request->all());
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'application_id' => 'exists:applications,_id',
                'type' => 'string|in:passport,driver_license,citizenship,Other',
                'number' => 'requiredif:type,passport,driver_license,citizenship',
                'issue_date' => 'date|requiredif:type,passport,driver_license,citizenship',
                'issue_district' => 'string|requiredif:type,passport,driver_license,citizenship',
                'is_verified' => 'boolean',
            ]);
            $project = $this->service->update($id, $request->all());
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

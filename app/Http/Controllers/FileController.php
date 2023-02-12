<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Application\FileService;

class FileController extends BaseController
{

    public $service;

    public function __construct(FileService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'document_id' => 'required|exists:documents,_id',
                'url' => 'string',
                'name' => 'string',
            ]);
            // check if is_verified is true
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
                'document_id' => 'exists:documents,_id',
                'url' => 'string',
                'name' => 'string',
            ]);
            $project = $this->service->update($id, $request->all());
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

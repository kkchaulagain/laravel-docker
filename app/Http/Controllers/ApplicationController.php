<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Application\ApplicationService;

class ApplicationController extends BaseController
{

    public $service;

    public function __construct(ApplicationService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'account_id' => 'required|exists:accounts,_id',
                'status' => 'in:pending,approved,rejected',
                'reference_code' => 'required|string',
                'digital_banking' => 'boolean',
                'remarks' => 'string',
                'collect_cheque' => 'boolean',

            ]);
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
                'account_id' => 'exists:accounts,_id',
                'status' => 'in:pending,approved,rejected',
                'reference_code' => 'string',
                'digital_banking' => 'boolean',
                'remarks' => 'string',
                'collect_cheque' => 'boolean',

            ]);
            $project = $this->service->update( $id, $request->all());
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

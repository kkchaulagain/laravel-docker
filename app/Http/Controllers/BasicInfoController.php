<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Application\BasicInfoService;

class BasicInfoController extends BaseController
{

    public $service;

    public function __construct(BasicInfoService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'application_id' => 'required|exists:applications,_id',
                'salutation' => 'required|in:Mr,Mrs,Ms',
                'account_opening_type' => 'required|in:Individual,Minor',
                'first_name' => 'required|string|max:20',
                'middle_name' => 'string|max:20',
                'last_name' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'email' => 'required|email',
                'mobile' => 'required|min:10',
                'apply_from_country' => 'required',
                'other_details' => 'max:200',
                'gender' => 'required|in:male,female,other',
                'marital_status' => 'required|in:married,single,divorced,widowed',
                'nationality' => 'required',
                'pan_number' => 'max:20',

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
                'application_id' => 'exists:applications,_id',
                'salutation' => 'in:Mr,Mrs,Ms',
                'account_opening_type' => 'in:Individual,Minor',
                'first_name' => 'string|max:20',
                'middle_name' => 'string|max:20',
                'last_name' => 'string|max:20',
                'date_of_birth' => 'date',
                'email' => 'email',
                'mobile' => 'min:10',
                'apply_from_country' => 'string',
                'other_details' => 'max:200',
                'gender' => 'in:male,female,other',
                'marital_status' => 'in:married,single,divorced,widowed',
                'nationality' => 'string',
                'pan_number' => 'max:20',

            ]);
            $project = $this->service->update($id, $request->all());
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

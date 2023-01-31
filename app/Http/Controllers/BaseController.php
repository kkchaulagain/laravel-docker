<?php

namespace App\Http\Controllers;

use App\Services\BaseDatabaseService;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    public $service;

    public function __construct(BaseDatabaseService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $projects = $this->service->filter($request)->paginate();
            return $this->respond($projects);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           
            $project = $this->service->store($request->all());
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
           
            $project = $this->service->find($id);
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $project = $this->service->update($request->all(), $id);
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $project = $this->service->delete($id);
            return $this->successResponse($project);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}

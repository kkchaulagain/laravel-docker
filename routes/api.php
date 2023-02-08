<?php

use App\Http\Controllers\RequirementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// prefix v1
Route::prefix("v1")->group(function () {
    Route::get("/requirement", RequirementController::class . "@generateRequirement");
});

Route::get("/test/error", function () {
    throw new BadRequestHttpException("Test Error Trace");
});

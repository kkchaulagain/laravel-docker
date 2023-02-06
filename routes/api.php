<?php

use App\Http\Controllers\BuildController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequirementController;
use Illuminate\Http\JsonResponse;
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

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});
// prefix v1
Route::prefix("v1")->group(function () {
    Route::get("/requirement", RequirementController::class . "@generateRequirement");
    Route::get("/schema", RequirementController::class . "@generateSchema");

    Route::get("projects/{id}", ProjectController::class . "@select");
    Route::resource("projects", ProjectController::class);
    Route::post("projects/{id}/build", ProjectController::class . "@generateRequirement");
    Route::post("projects/{id}/schema", ProjectController::class . "@generateSchema");
    Route::resource("builds", BuildController::class);
});

Route::get("/test/error", function () {
    throw new BadRequestHttpException("Test Error Trace");
});

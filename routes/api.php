<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BasicInfoController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FileController;
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
    // prefix account
    Route::prefix("accounts")->group(function () {
        Route::get("/", [AccountController::class, "index"]);
        Route::get("/{id}", [AccountController::class, "show"]);
        Route::post("/", [AccountController::class, "store"]);
        Route::put("/{id}", [AccountController::class, "update"]);
        Route::delete("/{id}", [AccountController::class, "destroy"]);
    });
    // prefix application
    Route::prefix("applications")->group(function () {
        Route::get("/", [ApplicationController::class, "index"]);
        Route::get("/{id}", [ApplicationController::class, "show"]);
        Route::post("/", [ApplicationController::class, "store"]);
        Route::put("/{id}", [ApplicationController::class, "update"]);
        Route::delete("/{id}", [ApplicationController::class, "destroy"]);
    });

    // prefix basic-info
    Route::prefix("basic-infos")->group(function () {
        Route::get("/", [BasicInfoController::class, "index"]);
        Route::get("/{id}", [BasicInfoController::class, "show"]);
        Route::post("/", [BasicInfoController::class, "store"]);
        Route::put("/{id}", [BasicInfoController::class, "update"]);
        Route::delete("/{id}", [BasicInfoController::class, "destroy"]);
    });

    // prefix document
    Route::prefix("documents")->group(function () {
        Route::get("/", [DocumentController::class, "index"]);
        Route::get("/{id}", [DocumentController::class, "show"]);
        Route::post("/", [DocumentController::class, "store"]);
        Route::put("/{id}", [DocumentController::class, "update"]);
        Route::delete("/{id}", [DocumentController::class, "destroy"]);
    });

    // prefix file
    Route::prefix("files")->group(function () {
        Route::get("/", [FileController::class, "index"]);
        Route::get("/{id}", [FileController::class, "show"]);
        Route::post("/", [FileController::class, "store"]);
        Route::put("/{id}", [FileController::class, "update"]);
        Route::delete("/{id}", [FileController::class, "destroy"]);
    });
});

Route::get("/test/error", function () {
    throw new BadRequestHttpException("Test Error Trace");
});

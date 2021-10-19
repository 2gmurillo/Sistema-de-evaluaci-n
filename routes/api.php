<?php

use App\Http\Controllers\Api\V1\TestResultController;
use App\Http\Controllers\Api\V1\QuestionController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->name('v1.')->group(function () {
    Route::apiResource('questions', QuestionController::class)
        ->only(['index']);
    Route::post('test-result', [TestResultController::class, 'check'])->name('test-result.check');
});

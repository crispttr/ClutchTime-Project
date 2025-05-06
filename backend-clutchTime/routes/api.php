<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StoryController;
use App\Http\Controllers\Api\V1\ChapterController;
use App\Http\Controllers\Api\V1\ChoiceController;

use App\Http\Controllers\Api\WelcomeMessageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::prefix('v1')->group(function () {
    Route::apiResource('stories', StoryController::class);
    Route::apiResource('chapters', ChapterController::class);
    Route::apiResource('choices', ChoiceController::class);
});
require __DIR__.'/auth.php';
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/welcome-message', WelcomeMessageController::class);
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'destroy']);


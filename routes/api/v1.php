<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoryJsonController;
use App\Http\Controllers\Api\V1\PostJsonController;

Route::prefix('v1')->group(function () {
    Route::apiResource('posts', PostJsonController::class);
    Route::apiResource('categories', CategoryJsonController::class);
});

<?php

use App\Http\Controllers\Api\V1\AuthJsonController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->middleware(['api'])->group(function () {
    Route::post('login', [AuthJsonController::class, 'login']);
    Route::post('logout', [AuthJsonController::class, 'logout']);
    Route::post('refresh', [AuthJsonController::class, 'refresh']);
    Route::post('me', [AuthJsonController::class, 'me']);
});
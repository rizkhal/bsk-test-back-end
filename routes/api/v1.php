<?php

use App\Http\Controllers\Api\V1\SuggestionJsonController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth')->group(function () {
    Route::apiResource('suggestions', SuggestionJsonController::class);
});

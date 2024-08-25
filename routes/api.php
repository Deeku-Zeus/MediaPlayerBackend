<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageAnalysisController;

// Define an open API route
Route::post('/v1/get/imageAnalyzer',[ImageAnalysisController::class,'storeAnalyzeRequest']);
Route::post('/v1/get/getDetectionResponse',[ImageAnalysisController::class,'getDetectionResponse']);

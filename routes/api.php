<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageAnalysisController;

// Define an open API route
Route::post('/v1/get/imageAnalyzer',[ImageAnalysisController::class,'storeAnalyzeRequest']);
Route::post('/v1/get/getDetectionResponse',[ImageAnalysisController::class,'getDetectionResponse']);
Route::post('/v1/put/updateAnalyzeData',[ImageAnalysisController::class,'updateAnalyzeData']);
Route::post('/v1/get/getResponseHistory',[ImageAnalysisController::class,'getResponseHistory']);
Route::post('/v1/get/getEcomProducts',[ImageAnalysisController::class,'getEcomProducts']);
Route::post('/v1/get/getUserRequests',[ImageAnalysisController::class,'getUserRequests']);

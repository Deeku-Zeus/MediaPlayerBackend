<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageAnalysisController;

// Define an open API route
Route::post('/v1/get/imageAnalyser',[ImageAnalysisController::class,'storeRequest']);

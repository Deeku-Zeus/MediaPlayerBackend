<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageAnalysisStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageAnalysisController extends ApiBaseController
{
    public function __construct()
    {

    }

    /**
     * Store the analyze request received from frontend
     *
     * @param ImageAnalysisStoreRequest $request
     */
    public function storeRequest(ImageAnalysisStoreRequest $request){
        // Log the file details
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info('File received: ' . $file->getClientOriginalName());
        } else {
            Log::warning('No file received in the request.');
        }

        // Your existing code to handle the request
    }
}

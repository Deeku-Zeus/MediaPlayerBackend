<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageAnalysisStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    public function storeRequest(ImageAnalysisStoreRequest $request)
    {
        $data = [
            "result" => true,
            "status" => "success",
            "message" => "Image analyze request saved successfully.",
            "is_analyzed" => false,
            "request_token" => (string) Str::uuid().'-'.time()
        ];
        return response()->json(
            $data,
            empty($data) ? 204 : 200
        );
    }
}

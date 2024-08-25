<?php

    namespace App\Services\ImageAnalyzer;

    use App\Facades\EcomApi;
    use App\Jobs\AnalyzeImage;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    class ImageAnalyzerService
    {
        /**
         * ImageAnalyzerService constructor.
         */
        public function __construct()
        {
        }

        /**
         * Store Analyzer Request
         *
         * @param $request
         *
         * @return array
         */
        public function storeAnalyzeRequest($request): array
        {
            $response = collect(['result'=>true,'status'=>'success','message'=>'Image analyze request saved successfully.']);
            $request = collect($request);
            $requestToken = $request->get('request_token', (string)Str::uuid() . '-' . time());
            $filePath = $this->uploadFile($request->get('image'));
            $apiRequest = [
                'image'     => $filePath,
                'request_token' => $requestToken,
                'videoName'    => $request->get('videoName', null),
                'timestamp'    => $request->get('timestamp', null),
                'username'     => $request->get('username', null),
                'profile_name' => $request->get('profile_name', null),
                'is_analyzed'  => false

            ];
            $apiResponse = EcomApi::upsertImageAnalyzer($apiRequest);
            if (!$apiResponse['result']){
                $requestToken = "";
                $response->put('result',false);
                $response->put('status',"error");
                $response->put('message',"Upsert Image Analyzer API failed");
            }
            //Call ML API as a parallel process
            $response->put('is_analyzed',false);
            $response->put('request_token',$requestToken);
            $file = "testService".time();
            Storage::disk('public')->put($file, '');
            AnalyzeImage::dispatch($apiRequest);
            return $response->toArray();
        }

        /**
         * Upload the file in Storage
         *
         * @param $file
         *
         * @return bool|string
         */
        private function uploadFile($file): bool|string
        {
            // Get the original file name
            $originalFileName = $file->getClientOriginalName();

            // Store the file with the original name in the 'uploads' directory
            return Storage::putFileAs('uploads', $file, $originalFileName);
        }
    }

<?php

    namespace App\Services\ImageAnalyzer;

    use App\Facades\AnalyzeApi;
    use App\Facades\EcomApi;
    use App\Jobs\AnalyzeImage;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    class ImageAnalyzerService
    {
        const OBJECT_COUNT = 5;

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
            $response = collect(['result' => true, 'status' => 'success', 'message' => 'Image analyze request saved successfully.']);
            $request = collect($request);
            $requestToken = $request->get('request_token', (string)Str::uuid() . '-' . time());
            $filePath = $this->uploadFile($request->get('image'));
            $imagename = basename($filePath);
            $apiRequest = [
                'image'         => $filePath,
                'request_token' => $requestToken,
                'videoName'     => $request->get('videoName', null),
                'timestamp'     => $request->get('timestamp', null),
                'username'      => $request->get('username', null),
                'profile_name'  => $request->get('profile_name', null),
                'is_analyzed'   => false

            ];
            $apiResponse = EcomApi::upsertImageAnalyzer($apiRequest);
            if (!$apiResponse['result']) {
                $requestToken = "";
                $response->put('result', false);
                $response->put('status', "error");
                $response->put('message', "Upsert Image Analyzer API failed");
            }
            //Call ML API as a parallel process
            $response->put('is_analyzed', false);
            $response->put('request_token', $requestToken);
            $request = ['image' => $imagename, 'object_count' => self::OBJECT_COUNT];
            AnalyzeImage::dispatch($request, $requestToken);
            return $response->toArray();
        }

        /**
         * Get analyzed data
         *
         * @param $request
         *
         * @return array
         */
        public function getDetectionResponse($request): array
        {
            $request = collect($request);
            $response = collect(['result' => true, 'status' => 'success', 'message' => 'Image analyze response fetched successfully.']);
            $requestToken = $request->get('request_token');
            $uid = $request->get('uid', []);
            if (!$requestToken) {
                $response->put('result', false);
                $response->put('status', 'error');
                $response->put('message', 'Request token required');
            }
            return EcomApi::getDetectionResponse(['request_token' => $requestToken, 'uid' => $uid]);
        }

        /**
         * Update Analyzer Response
         *
         * @param $request
         *
         * @return array
         */
        public function updateAnalyzeData($request): array
        {
            $request = collect($request);
            $uid = $request->get('uid');
            if (!$uid) {
                return [
                    "result"  => false,
                    "status"  => "failed",
                    "message" => "UID is not provided",
                ];
            }
            $tags = explode(',',$request->get('tags'));
            $color = $request->get('color');
            if (empty($tags) && empty($color)) {
                return [
                    "result"  => false,
                    "status"  => "failed",
                    "message" => "Nothing to update",
                ];
            }
            $apiRequest = collect();
            $apiRequest->put('uid',$uid);
            if (!empty($tags)) {
                $apiRequest->put('tags', base64_encode(json_encode($tags)));
            }
            if (!empty($color)) {
                $apiRequest->put('color', $color);
            }
            return EcomApi::updateAnalyzeData($apiRequest->toArray());
        }
        /**
         * Get Response History of Video
         *
         * @param $request
         *
         * @return array
         */
        public function getResponseHistory($request): array
        {
            $request = collect($request);
            $videoName = $request->get('videoName');
            if (!$videoName){
                return [
                    "result"  => false,
                    "status"  => "failed",
                    "message" => "Video Name is not provided",
                ];
            }
            $page = $request->get('page',1);
            $apiRequest = collect(['videoName'=>$videoName,'page'=>$page]);
            return EcomApi::getResponseHistory($apiRequest->toArray());
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

            // Store the file with the original name in the 'uploads' directory on the 'public' disk
            $path = $file->storeAs('uploads', $originalFileName, 'public');

            // Return the URL to access the file
            return Storage::url($path);
        }
    }

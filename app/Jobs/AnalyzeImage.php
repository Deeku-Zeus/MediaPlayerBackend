<?php

    namespace App\Jobs;

    use App\Facades\AnalyzeApi;
    use App\Facades\EcomApi;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;

    class AnalyzeImage implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        protected array $apiRequest;
        protected string $requestToken;

        /**
         * Create a new job instance.
         *
         * @param array  $apiRequest
         * @param string $requestToken
         */
        public function __construct(array $apiRequest,string $requestToken)
        {
            $this->apiRequest = $apiRequest;
            $this->requestToken = $requestToken;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            $response = collect(AnalyzeApi::detect($this->apiRequest));
            Log::info($response);
            $this->storeAnalyzedResponse($response,$this->requestToken);
        }

        private function storeAnalyzedResponse($response,$requestToken){
            $upsertResponseData = $response->map(function ($item, $key) use($requestToken) {
                $item = collect($item['obj']);
                if ($item->isNotEmpty()) {
                    $responseData = collect();
                    $responseData->put('coordinates', base64_encode(json_encode($item->get('coordinates'))));
                    $responseData->put('confidence', $item->get('confidence'));
                    $responseData->put('uid', $item->get('uid'));
                    $responseData->put('color', $item->get('color'));
                    $responseData->put('tags', base64_encode(json_encode($item->get('tags'))));
                    $responseData->put('request_token', $requestToken);
                    return $responseData;
                }
                // Return null or empty collection if $item is empty to maintain structure in $upsertResponseData
                return collect();
            })->filter();
            EcomApi::storeAnalyzedResponse($upsertResponseData->toArray());
        }
    }

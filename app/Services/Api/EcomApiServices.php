<?php

    namespace App\Services\Api;

    use App\Util\Api\InternalApiUtil;
    use Illuminate\Http\Client\ConnectionException;
    use Illuminate\Http\Client\RequestException;
    use Illuminate\Support\Facades\Crypt;

    /**
     * Energy Contract Api Service
     *
     */
    class EcomApiServices
    {
        private InternalApiUtil $util;

        /**
         * Construct
         */
        public function __construct()
        {
            $this->util = new InternalApiUtil(config('app.apiUrl.ecomApi'), config('internalApi.ecomApi.endpoint.token'));
        }

        /**
         * @param $analyzeData
         *
         * @return mixed
         * @throws RequestException
         * @throws ConnectionException
         */
        public function upsertImageAnalyzer($analyzeData): mixed
        {
            return $this->util->post('v1/ecomBackend/put/analyzerRequest', $analyzeData);
        }

        /**
         * @param $request
         *
         * @return mixed
         * @throws \Illuminate\Http\Client\ConnectionException
         * @throws \Illuminate\Http\Client\RequestException
         */
        public function getDetectionResponse($request): mixed
        {
           return $this->util->post('v1/ecomBackend/get/analyzedResponse', $request);
        }
        /**
         * @param $requestToken
         *
         * @return mixed
         * @throws \Illuminate\Http\Client\ConnectionException
         * @throws \Illuminate\Http\Client\RequestException
         */
        public function storeAnalyzedResponse($request): mixed
        {
            return $this->util->post('v1/ecomBackend/put/storeAnalyzedResponse', $request);
        }
    }

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
    }

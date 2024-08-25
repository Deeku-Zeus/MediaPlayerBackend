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
    class AnalyzeApiServices
    {
        private InternalApiUtil $util;

        /**
         * Construct
         */
        public function __construct()
        {
            $this->util = new InternalApiUtil(config('app.apiUrl.mlApi'), '');
        }

        /**
         * @param $analyzeData
         *
         * @return mixed
         * @throws RequestException
         * @throws ConnectionException
         */
        public function detect($analyzeData): mixed
        {
            return $this->util->postMl('', $analyzeData);
        }
    }

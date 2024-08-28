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
         const OBJECT_COUNT = 5;
        private InternalApiUtil $util;

        /**
         * Construct
         */
        public function __construct()
        {
            $this->util = new InternalApiUtil(config('app.apiUrl.mlApi'), '');
        }

        /**
         * @param $request
         *
         * @return mixed
         * @throws \Illuminate\Http\Client\ConnectionException
         * @throws \Illuminate\Http\Client\RequestException
         */
        public function detect($request): mixed
        {
            return $this->util->postMl('detect', $request);
        }
    }

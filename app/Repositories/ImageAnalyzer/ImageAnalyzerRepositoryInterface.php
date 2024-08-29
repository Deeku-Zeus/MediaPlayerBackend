<?php

    namespace App\Repositories\ImageAnalyzer;
    /*
     * ImageAnalyzerRepositoryInterface
     */

    interface ImageAnalyzerRepositoryInterface
    {
        /**
         * @param array $request
         *
         * @return array
         */
        public function storeAnalyzeRequest(array $request): array;

        /**
         * @param array $request
         *
         * @return array
         */
        public function getDetectionResponse(array $request): array;

        /**
         * @param array $request
         *
         * @return array
         */
        public function updateAnalyzeData(array $request): array;
    }

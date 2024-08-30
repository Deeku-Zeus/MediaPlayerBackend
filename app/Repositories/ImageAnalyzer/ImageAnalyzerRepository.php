<?php

    namespace App\Repositories\ImageAnalyzer;

    use App\Services\ImageAnalyzer\ImageAnalyzerService;

    class ImageAnalyzerRepository implements ImageAnalyzerRepositoryInterface
    {
        /**
         * @var ImageAnalyzerService
         */
        protected ImageAnalyzerService $imageAnalyzerService;

        /**
         * ImageAnalyzerRequestExecRepository constructor.
         *
         * @param ImageAnalyzerService $analyzerService
         */
        public function __construct(ImageAnalyzerService $analyzerService)
        {
            $this->imageAnalyzerService = $analyzerService;
        }

        /**
         * @param array $request
         *
         * @return array
         */
        public function storeAnalyzeRequest(array $request): array
        {
            return $this->imageAnalyzerService->storeAnalyzeRequest($request);
        }

        /**
         * @param array $request
         *
         * @return array
         */
        public function getDetectionResponse(array $request): array
        {
            return $this->imageAnalyzerService->getDetectionResponse($request);
        }

        /**
         * @param array $request
         *
         * @return array
         */
        public function updateAnalyzeData(array $request): array
        {
            return $this->imageAnalyzerService->updateAnalyzeData($request);
        }

        public function getResponseHistory(array $request): array
        {
            return $this->imageAnalyzerService->getResponseHistory($request);
        }

        public function getEcomProducts(array $request): array
        {
            return $this->imageAnalyzerService->getEcomProducts($request);
        }

        public function getUserRequests(array $request): array
        {
            return $this->imageAnalyzerService->getUserRequests($request);
        }
    }

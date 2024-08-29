<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\GetAnalyzedDataHistoryRequest;
    use App\Http\Requests\GetDetectionResponseRequest;
    use App\Http\Requests\GetEcomProductsRequest;
    use App\Http\Requests\ImageAnalysisStoreRequest;
    use App\Http\Requests\UpdateAnalyzeDataRequest;
    use App\Repositories\ImageAnalyzer\ImageAnalyzerRepositoryInterface;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

    class ImageAnalysisController extends ApiBaseController
    {
        /**
         * @var ImageAnalyzerRepositoryInterface
         */
        protected ImageAnalyzerRepositoryInterface $imageAnalyzer;

        public function __construct(ImageAnalyzerRepositoryInterface $ImageAnalyzer)
        {
            $this->imageAnalyzer = $ImageAnalyzer;
            parent::__construct();
        }

        /**
         * Store the analyze request received from frontend
         *
         * @param ImageAnalysisStoreRequest $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function storeAnalyzeRequest(ImageAnalysisStoreRequest $request): JsonResponse
        {
            $image = $request->file('image');
            $request = $request->all();
            $request['image'] = $image;
            $data = $this->imageAnalyzer->storeAnalyzeRequest($request);

            return response()->json(
                $data,
                empty($data) ? 204 : 200
            );
        }

        /**
         * Fetch the analyze data from ML
         *
         * @param \App\Http\Requests\GetDetectionResponseRequest $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function getDetectionResponse(GetDetectionResponseRequest $request): JsonResponse
        {
            $data = $this->imageAnalyzer->getDetectionResponse($request->all());
            return response()->json(
                $data,
                empty($data) ? 204 : 200
            );
        }

        /**
         * Fetch the analyze data from ML
         *
         * @param UpdateAnalyzeDataRequest $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function updateAnalyzeData(UpdateAnalyzeDataRequest $request): JsonResponse
        {
            $data = $this->imageAnalyzer->updateAnalyzeData($request->all());
            return response()->json(
                $data,
                empty($data) ? 204 : 200
            );
        }

        /**
         * Fetch the analyze data from ML
         *
         * @param \App\Http\Requests\GetAnalyzedDataHistoryRequest $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function getResponseHistory(GetAnalyzedDataHistoryRequest $request): JsonResponse
        {
            $data = $this->imageAnalyzer->getResponseHistory($request->all());
            return response()->json(
                $data,
                empty($data) ? 204 : 200
            );
        }
        /**
         * Fetch the analyze data from ML
         *
         * @param \App\Http\Requests\GetAnalyzedDataHistoryRequest $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function getEcomProducts(GetEcomProductsRequest $request): JsonResponse
        {
            $data = $this->imageAnalyzer->getEcomProducts($request->all());
            return response()->json(
                $data,
                empty($data) ? 204 : 200
            );
        }

    }

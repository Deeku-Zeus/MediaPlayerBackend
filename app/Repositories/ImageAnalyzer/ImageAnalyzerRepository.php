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
     * @param ImageAnalyzerService $analyzerService
     */
    public function __construct(ImageAnalyzerService $analyzerService)
    {
        $this->imageAnalyzerService = $analyzerService;
    }

    /**
     * @param array $request
     * @return array
     */
    public function storeAnalyzeRequest(array $request): array
    {
        return $this->imageAnalyzerService->storeAnalyzeRequest($request);
    }
}

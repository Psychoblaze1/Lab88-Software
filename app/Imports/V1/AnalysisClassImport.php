<?php

namespace App\Imports\V1;

use App\Services\AnalysisClassService;
use App\Traits\StringTrait;

class AnalysisClassImport
{
    use StringTrait;
    protected  $analysisClassService;

    public function __construct(AnalysisClassService $analysisClassService)
    {
        $this->analysisClassService = $analysisClassService;
    }

    public function handle($items)
    {

        foreach ($items as $item) {
            // Create TestParameter
            $this->analysisClassService->firstOrCreate($item);
        }
    }
}

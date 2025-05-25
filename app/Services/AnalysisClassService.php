<?php

namespace App\Services;

use App\Actions\AnalysisClassActions;


class AnalysisClassService
{
    protected $analysisClassActions;
    public function __construct(AnalysisClassActions $analysisClassActions)
    {
        $this->analysisClassActions = $analysisClassActions;
    }

    public function firstOrCreate(object $data)
    {
        return $this->analysisClassActions->firstOrCreate($data);
    }
}

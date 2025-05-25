<?php

namespace App\Services;

use App\Models\LimitParameter;
use App\Models\SampleResult;

class ComparisonService
{
    protected $sampleService;

    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }

    public function compareResultToLimit(SampleResult $sampleResult, LimitParameter $limitParameter)
    {
        $value = $sampleResult->value;
        $min = $limitParameter->min;
        $max = $limitParameter->max;
        $comparator = $limitParameter->comparator;


        switch ($comparator) {
            case '<':
                return $value <= $max;
                break;
            case '>':
                return $value >= $min;
                break;
            case '><':
                return $value >= $min && $value <= $max;
                break;
            case '><':
                return $value <= $min && $value >= $max;
                break;
            case '!=': // only set a min value for these
                return $value !== $min;
                break;
        }
    }
}

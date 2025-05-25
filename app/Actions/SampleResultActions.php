<?php

namespace App\Actions;

use App\Models\Sample;
use App\Models\SampleResult;

class SampleResultActions
{

    public function createResult(Sample $sample, $testParamtereId, $value = null)
    {
        return $sample->results()->create(
            [
                'test_parameter_id' => $testParamtereId,
                'value' => $value
            ]
        );
    }
}

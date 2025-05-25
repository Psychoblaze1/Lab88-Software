<?php

namespace App\Actions;

use App\Models\LimitSuite;

class LimitActions
{

    public function createLimitSuite(string $name)
    {
        return LimitSuite::create(
            ['name' => $name]
        );
    }

    public function createLimitParameters(LimitSuite $limitSuite, object $data)
    {
        return $limitSuite->limitParameters()->create(
            [
                'test_parameter_id' => $data->test_parameter_id,
                'min' => $data->min,
                'max' => $data->max,
                'comparator' => $data->comparator,
            ]
        );
    }

    public function getLimitParameter(LimitSuite $limitSuite, string $testParamterId)
    {
        return $limitSuite->limitParameters()->where('test_parameter_id', $testParamterId)->first();
    }
}

<?php

namespace App\Services;

use App\Models\Account;
use App\Services\TestParameterService;
use App\Services\LimitService;

class DevService
{
    protected $testParamterService, $limitService, $sampleService, $comparisonService;

    public function __construct(TestParameterService $testParameterService, LimitService $limitService, SampleService $sampleService, ComparisonService $comparisonService)
    {
        $this->testParamterService = $testParameterService;
        $this->limitService = $limitService;
        $this->sampleService = $sampleService;
        $this->comparisonService = $comparisonService;
    }

    public function dev()
    {
        // get limitParamIds by category Name
        $testParameters = $this->testParamterService->getTestParamtersByCategoryName('distilation');
        $testParameterIds = $testParameters->pluck('id');

        // Create Limit
        $limitSuite = $this->limitService->createLimitSuite('test: ' . now());
        foreach ($testParameterIds as $paramId) {
            $data =  [
                'test_parameter_id' => $paramId,
                'min' => random_int(0, 100),
                'max' => random_int(100, 200),
                'comparator' => '><'
            ];
            $data = json_decode(json_encode($data));
            $this->limitService->createLimitParameters($limitSuite, $data);
        }
        // Create Limit


        // create sample -> get parameters to test: from limitSuite / category [offer to save as new test suite]
        $account = Account::first();
        $sample = $this->sampleService->createSampleByAccount($account, 'spl: ' . now(), $limitSuite->id);

        $limitParameters = $sample->limitSuite->limitParameters;
        // store pending sample results by test limit and await processing
        foreach ($limitParameters as $limitParameter) {
            $this->sampleService->createResult($sample, $limitParameter->test_parameter_id);
        }
        // test and update result values and status

        $sampleResults = $this->sampleService->getPendingSampleResults($sample);

        foreach ($sampleResults as $sampleResult) {
            $sampleResult->value = random_int(0, 300);

            if ($sampleResult->save()) {
                $sampleResult->changeStatus(1);
            }
        }

        // Compare to limits
        $sampleResults = $this->sampleService->getTestedSampleResults($sample);
        foreach ($sampleResults as $sampleResult) {
            //get parameterLimitTest
            $limitParameter = $this->limitService->getLimitParameter($limitSuite, $sampleResult->test_parameter_id);
            $compare = $this->comparisonService->compareResultToLimit($sampleResult, $limitParameter);

            $sampleResult->diagnosis = $compare;

            if ($sampleResult->save()) {
                $sampleResult->changeStatus(1);
            }
        }
        dd($sampleResults);
    }
}

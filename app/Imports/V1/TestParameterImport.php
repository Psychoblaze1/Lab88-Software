<?php

namespace App\Imports\V1;

use App\Services\TestStandardService;
use App\Services\TestParameterService;
use App\Traits\StringTrait;

class TestParameterImport
{
    use StringTrait;
    protected $testParameterService, $testParameterCategoryService, $testStandardService;

    public function __construct(TestParameterService $testParameterService, TestStandardService $testStandardService)
    {
        $this->testParameterService = $testParameterService;
        $this->testStandardService = $testStandardService;
    }

    public function handle($items)
    {
        foreach ($items as $item) {
            // Create TestParameter
            $parameter =  $this->testParameterService->firstOrCreateTestParameter($item);

            // handle category data
            $category =   $this->testParameterService->firstOrCreateCategory($item->category);
            // link parameter to category
            $parameter->category_id = $category->id;
            $parameter->save();

            // handle standards data
            foreach ($item->test_standards as $standard) {
                $testStandard = $this->testStandardService->firstOrCreate($standard);
                $parameter->testStandards()->attach($testStandard);
            }
        }
    }
}

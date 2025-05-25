<?php

namespace App\Services;

use App\Actions\TestParameterActions;
use App\Models\TestParameterCategory;
use App\Services\TestStandardService;
use Illuminate\Support\Facades\DB;

class TestParameterService
{
    protected $testParameterActions, $testStandardService;
    public function __construct(TestParameterActions $testParameterActions, TestStandardService $testStandardService)
    {
        $this->testParameterActions = $testParameterActions;
        $this->testStandardService = $testStandardService;
    }

    public function createTestParameter(object $data)
    {
        // check if exists
        if (!$this->testParameterActions->testParameterExists($data->name)) {
            // create new
            return $this->testParameterActions->create($data);
        }
    }

    public function firstOrCreateTestParameter(object $data)
    {
        $parameter = $this->testParameterActions->firstOrCreate($data->name, $data->unit, $data->description);
        // FIX THIS
        if (isset($data->category)) {
            $this->firstOrCreateCategory($data->category);
        }

        if (isset($data->test_standards)) {
            if ($data->test_standards !== null) {
                foreach ($data->test_standards as $standard) {
                    $standard =  $this->testStandardService->firstOrCreate($standard);
                    $parameter->testStandards()->attach($standard);
                }
            }
        }
        return $parameter;
    }

    public function categoryExists(string $categoryName)
    {
        return TestParameterCategory::where('name', $categoryName)->exists();
    }

    public function createCategory(object $data): object
    {
        $model = TestParameterCategory::create(
            ['name' => $data->name]
        );

        if (isset($data->description)) {
            $model->description()->create(
                ['content' => $data->description]
            );
        }
        return $model;
    }

    public function firstOrCreateCategory(string $name): object
    {
        $category = TestParameterCategory::firstOrCreate(
            ['name' => $name]
        );
        return $category;
    }


    public function getTestParamtersByCategoryName(string $categoryName)
    {
        return TestParameterCategory::with('testParameters')->where('name', $categoryName)->first()->testParameters;
    }
}

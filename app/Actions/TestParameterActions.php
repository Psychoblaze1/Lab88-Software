<?php

namespace App\Actions;

use App\Models\TestParameter;

class TestParameterActions
{

    public function testParameterExists(string $name): bool
    {
        return TestParameter::where('name', $name)->exists();
    }

    public function create($name, $unit = null, $description = null) //TODO: change this to take in the values needed, do checks etc in service
    {

        $model = TestParameter::create(
            [
                'name' => $name,
                'unit' => $unit
            ]
        );

        if (isset($description)) {
            $model->description()->create(
                [
                    'content' => $description
                ]
            );
        }
        return $model;
    }


    public function firstOrCreate($name, $unit = null, $description = null)
    {

        $model = TestParameter::firstOrCreate(
            [
                'name' => $name,
            ],
            [
                'unit' => $unit
            ]
        );

        if (isset($description)) {
            $model->description()->create(
                [
                    'content' => $description
                ]
            );
        }
        return $model;
    }

    public function getTestParameter(TestParameter $testParameter)
    {
        return TestParameter::find($testParameter);
    }
}

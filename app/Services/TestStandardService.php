<?php

namespace App\Services;

use App\Actions\TestStandardActions;


class TestStandardService
{
    protected $testStandardActions;
    public function __construct(TestStandardActions $testStandardActions)
    {
        $this->testStandardActions = $testStandardActions;
    }

    public function firstOrCreate(object $data)
    {
        $description = null;
        if (isset($data->description)) {
            $description = $data->description;
        };

        return $this->testStandardActions->firstOrCreate($data->name, $description);
    }
}

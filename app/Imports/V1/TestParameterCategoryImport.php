<?php

namespace App\Imports\V1;

use App\Services\TestParameterService;
use App\Traits\StringTrait;

class TestParameterCategoryImport
{
    use StringTrait;
    protected  $testParameterCategoryService, $testParameterService;

    public function __construct(TestParameterService $testParameterService)
    {
        $this->testParameterService = $testParameterService;
    }

    public function handle($rows)
    {
        foreach ($rows as $row) {
            $data = [
                'name' => $row[0],
                'description' => $this->formatCsvString($row[1]),
            ];
            $data = json_decode(json_encode($data));
            $this->testParameterService->createCategory($data);
        }
    }
}

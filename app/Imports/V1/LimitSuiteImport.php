<?php

namespace App\Imports\V1;

use App\Services\AnalysisClassService;
use App\Services\LimitSuiteService;
use App\Traits\StringTrait;

class LimitSuiteImport
{
    use StringTrait;
    protected $limitSuiteService;

    public function __construct(LimitSuiteService $limitSuiteService)
    {
        $this->limitSuiteService = $limitSuiteService;
    }

    public function handle($rows)
    {

        foreach ($rows as $row) {
            $data = [
                'name' => $row[0],
                'description' => $this->formatCsvString($row[1]),
                'limits' => unserialize($row[2]),
            ];
            // Create TestParameter
            $data = json_decode(json_encode($data));
            $this->limitSuiteService->createLimitSuite($data);
        }
    }
}

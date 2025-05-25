<?php

namespace App\Imports\V1;

use App\Services\TestStandardService;
use App\Traits\StringTrait;

class TestStandardImport
{
    use StringTrait;
    protected $testStandardService;

    public function __construct(TestStandardService $testStandardService)
    {
        $this->testStandardService = $testStandardService;
    }

    public function handle($items)
    {
        foreach ($items as $item) {
            $this->testStandardService->firstOrCreate($item);
        }
    }
}

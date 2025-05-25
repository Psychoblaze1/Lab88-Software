<?php

namespace App\Services;

use App\Actions\LimitSuiteActions;


class LimitSuiteService
{
    protected $LimitSuiteActions;
    public function __construct(LimitSuiteActions $LimitSuiteActions)
    {
        $this->LimitSuiteActions = $LimitSuiteActions;
    }

    public function createLimitSuite()
    {
    }
}

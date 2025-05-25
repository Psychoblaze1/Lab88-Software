<?php

namespace App\Services;

use App\Actions\LimitActions;

class LimitService
{
    protected $limitActions;
    public function __construct(LimitActions $limitActions)
    {
        $this->limitActions = $limitActions;
    }

    public function createLimitSuite(string $name)
    {
        return $this->limitActions->createLimitSuite($name);
    }

    public function createLimitParameters($limitSuite, object $data)
    {
        return $this->limitActions->createLimitParameters($limitSuite, $data);
    }

    public function getLimitParameter($limitSuite, string $testParamterId)
    {
        return $this->limitActions->getLimitParameter($limitSuite, $testParamterId);
    }
}

<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AssetChain;

class DevService
{
    protected $testParamterService, $limitService, $sampleService, $comparisonService;

    public array $processedChainData = [];


    public function dev()
    {
        $accountId = Account::first()->id;
        $test = AssetChain::with('parent')->where(['account_id' => $accountId, 'type' => 'sample_point'])->get();

        dd($test);
    }
}

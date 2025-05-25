<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AssetChain;
use Illuminate\Http\Request;

class AssetChainController extends Controller
{
    public function getAssetChain()
    {
        $accountId = Account::first()->id;
        return AssetChain::where('account_id', $accountId)->get();
    }

    public function getSamplePoints()
    {
        $accountId = Account::first()->id;
        return AssetChain::with('parent')->where(['account_id' => $accountId, 'type' => 'sample_point'])->get();
    }
}

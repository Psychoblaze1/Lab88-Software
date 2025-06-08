<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AssetChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetChainController extends Controller
{
    public function getAssetChain()
    {
        $accountId = Auth::user()->account_id;
        return AssetChain::where('account_id', $accountId)->get();
    }

    public function getSamplePoints()
    {
        $accountId = Auth::user()->account_id;
        return AssetChain::with('parent')->where(['account_id' => $accountId, 'type' => 'sample_point'])->get();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{

    public function getAssets()
    {
        return Asset::all();
    }

    public function getAssetsByAccount(Request $request)
    {
        return Account::find($request->get('accountId'))->assets;
    }

    public function getAssetsBySite(Request $request)
    {
        return Asset::where('site_id', $request->route('id'))->get();
    }
}

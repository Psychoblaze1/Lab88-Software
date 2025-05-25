<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class AccountController extends Controller
{
    public function getAccounts()
    {
        return Account::all();
    }

    public function getAssetChain()
    {
        return Account::with(['children.sites.assets.components.samplePoints', 'sites.assets.components.samplePoints'])->get();
    }
}

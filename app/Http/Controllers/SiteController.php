<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function getSites()
    {
        return Site::all();
    }

    public function getSitesByAccount(Request $request)
    {
        return Site::where('account_id', $request->route('id'))->get();
    }
}

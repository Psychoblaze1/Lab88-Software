<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{

    public function getComponents()
    {
        return Component::all();
    }

    public function getComponentsByAsset(Request $request)
    {
        return Component::where('asset_id', $request->route('id'))->get();
    }
}

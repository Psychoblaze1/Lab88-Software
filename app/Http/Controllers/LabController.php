<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    public function getLabs()
    {
        return Lab::with('instruments.testParameters.testStandards', 'instruments.testStandards')->where('account_id', Auth::user()->account_id)->get();
    }
}

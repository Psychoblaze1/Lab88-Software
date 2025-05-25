<?php

namespace App\Http\Controllers;

use App\Models\LimitSuite;
use Illuminate\Http\Request;

class LimitSuiteController extends Controller
{
    public function getLimitSuites()
    {
        return LimitSuite::with('limitParameters')->get();
    }
}

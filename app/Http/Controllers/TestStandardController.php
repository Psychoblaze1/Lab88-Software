<?php

namespace App\Http\Controllers;

use App\Models\TestStandard;
use Illuminate\Http\Request;

class TestStandardController extends Controller
{
    public function getTestStandards()
    {
        return TestStandard::with(['description'])->get();
    }
}

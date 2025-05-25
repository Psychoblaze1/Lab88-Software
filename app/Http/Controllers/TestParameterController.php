<?php

namespace App\Http\Controllers;

use App\Models\TestParameter;
use App\Models\TestParameterCategory;

use function GuzzleHttp\Promise\all;

class TestParameterController extends Controller
{
    public function getTestParameters()
    {
        return TestParameter::with(['category', 'description'])->get();
    }

    public function getTestParameterCategories()
    {
        return TestParameterCategory::all();
    }
}

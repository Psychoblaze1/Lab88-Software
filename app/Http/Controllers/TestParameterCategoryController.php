<?php

namespace App\Http\Controllers;

use App\Models\TestParameterCategory;
use Illuminate\Http\Request;

class TestParameterCategoryController extends Controller
{
    public function getTestParameterCategories()
    {
        return TestParameterCategory::all();
    }
}

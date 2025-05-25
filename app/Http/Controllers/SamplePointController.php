<?php

namespace App\Http\Controllers;

use App\Models\SamplePoint;
use Illuminate\Http\Request;

class SamplePointController extends Controller
{
    public function getSamplePoints()
    {
        return SamplePoint::all();
    }
}

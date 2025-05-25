<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Services\InstrumentService;

class InstrumentController extends Controller
{

    protected $instrumentService;
    public function __construct(InstrumentService $instrumentService)
    {
        $this->instrumentService = $instrumentService;
    }

    public function getInstruments()
    {
        return Instrument::with(['testParameters', 'testStandards'])->get();
    }
}

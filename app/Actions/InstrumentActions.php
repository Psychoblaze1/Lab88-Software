<?php

namespace App\Actions;

use App\Models\Instrument;

class InstrumentActions
{

    public function getInstruments()
    {
        return Instrument::all();
    }

    public function firstOrCreate(string $name)
    {
        return Instrument::firstOrCreate(
            [
                'name' => $name
            ]
        );
    }
}

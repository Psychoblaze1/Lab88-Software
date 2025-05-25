<?php

namespace App\Imports\V1;

use App\Services\InstrumentService;
use App\Traits\StringTrait;

class InstrumentImport
{
    use StringTrait;
    protected $instrumentService;

    public function __construct(InstrumentService $instrumentService)
    {
        $this->instrumentService = $instrumentService;
    }

    public function handle($items)
    {
        foreach ($items as $item) {

            $this->instrumentService->firstOrCreate($item);
        }
    }
}

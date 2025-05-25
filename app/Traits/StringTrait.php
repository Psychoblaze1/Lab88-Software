<?php

namespace App\Traits;


trait StringTrait
{
    public function formatCsvString($string)
    {
        if (preg_match('/^\s*$/', $string)) {
            return null;
        }
        return trim($string);
    }
}

<?php

namespace App\Actions;

use Illuminate\Support\Facades\File;

class FIleActions
{

    public function getDirectoryContents($directory): array
    {
        $excluded = ['.', '..'];
        return array_values(array_diff(scandir($directory), $excluded));
    }

    public function convertCsvToArray($pathToFile, $delimeter = ',')
    {
        return array_map(function ($v) use ($delimeter) {
            return str_getcsv($v, $delimeter);
        }, file($pathToFile));
    }

    public function stripHeaderRowsFromArray(array $array, array $headerRows): array
    {
        foreach ($headerRows as $header) {
            unset($array[$header]);
        }
        return $array;
    }

    public function getFileName(string $pathToFile)
    {
        return File::name($pathToFile);
    }
}

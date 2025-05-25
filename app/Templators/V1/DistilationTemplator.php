<?php

namespace App\Templators\V1;

class DistilationTemplator
{
    public function template(array $stringDataArr, $obj = false)
    {

        $data = [];
        foreach ($stringDataArr as $row) {
            if (is_array($row)) {
                $row = $row[0];
            }

            array_push($data, explode(';', $row));
        }
        // Instrument data
        // $data[0]; header
        $formated = [
            "sample" => [
                'label' => $data[2][1],
                'sampleType' => $data[3][1],
                'timestamp' => $data[5][1],
            ],
            "instrument" => [
                'serialNumber' => $data[1][1],
                'limsId' => $data[9][1],
                'instrumentUser' => $data[4][1],
            ],
            "additional" => [
                'temperature' => $data[6][1],
                'fillVolume' => $data[7][1],
                'rinseCycles' => $data[8][1],
                'density' => $data[10][1],
                'densityAtTwenty' => $data[11][1],
            ],
            "results" => [],
        ];
        // $data[12]; null
        // Dynamic Sample Results
        // $data[13];header

        $results = [];
        // for dynamic result data
        for ($index = 14; $index <= (count($data) - 1); $index++) {
            if (array_key_exists($index, $data)) {
                $row = $data[$index];
                if (count($row) === 4) {
                    array_push($results, [
                        'label' =>  $row[0],
                        'value' =>  $row[1],
                        'unit' =>  $row[2],
                        'delta' =>  $row[3],
                    ]);
                }
            }
        }

        $formated['results'] = $results;

        if ($obj) {
            return json_decode(json_encode($formated));
        }
        return $formated;
    }
}

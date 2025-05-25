<?php

namespace App\Templators\V1;

class SpectroAromatics
{
    public function template(array $data, $obj = false)
    {
        $fixedArr = [];
        foreach ($data as $row) {
            $strToArr = explode(';', $row[0]);
            array_push($fixedArr, $strToArr);
        }
        //remove header
        unset($fixedArr[0]);
        $results = [];
        foreach ($fixedArr as $test) {
            if (count($test) > 1) {
                $formated = [
                    "sample" => [
                        "label" => $test[0],
                        "type" => $test[1],
                        "timestamp" => $test[3],
                        "user" => $test[2],
                        "limsIdent" => $test[7],
                    ],
                    "instrument" => [],
                    "additional" => [
                        "Temperature" => $test[4],
                        "Fill Volume" => $test[5],
                        "Rinsing Cycles" => $test[6],
                    ],
                    "results" => [
                        [
                            'label' => 'density',
                            'value' => $test[8]
                        ],
                        [
                            'label' => 'Density@20.0',
                            'value' => $test[9],
                            'unit' => 'C'
                        ],
                        [
                            'label' => 'Methanol',
                            'value' => $test[10],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'Ethanol',
                            'value' => $test[11],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'MTBE',
                            'value' => $test[12],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'ETBE',
                            'value' => $test[13],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'TAME',
                            'value' => $test[14],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'Benzene',
                            'value' => $test[15],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'Toluene',
                            'value' => $test[16],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'Total Aromatics',
                            'value' => $test[17],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'Total Oxygen',
                            'value' => $test[18],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'Total Olefines',
                            'value' => $test[19],
                            'unit' => '>m%'
                        ],
                        [
                            'label' => 'RON',
                            'value' => $test[20],
                            'unit' => ''
                        ],
                        [
                            'label' => 'MON',
                            'value' => $test[21],
                            'unit' => ''
                        ],
                        [
                            'label' => 'T10',
                            'value' => $test[22],
                            'unit' => 'C'
                        ],
                        [
                            'label' => 'T50',
                            'value' => $test[23],
                            'unit' => 'C'
                        ],
                        [
                            'label' => 'T90',
                            'value' => $test[24],
                            'unit' => 'C'
                        ],
                        [
                            'label' => 'DVPE',
                            'value' => $test[25],
                            'unit' => 'kPa'
                        ],
                        [
                            'label' => 'Cetane Index',
                            'value' => $test[26],
                            'unit' => ''
                        ],
                        [
                            'label' => 'IBP',
                            'value' => $test[27],
                            'unit' => 'C'
                        ],
                        [
                            'label' => 'T90',
                            'value' => $test[28],
                            'unit' => 'C'
                        ],
                        [
                            'label' => 'Kinematic Viscosity@40C',
                            'value' => $test[29],
                            'unit' => 'cSt'
                        ],
                        [
                            'label' => 'Kinematic Viscosity@-20C',
                            'value' => $test[30],
                            'unit' => 'm/s'
                        ],
                    ]
                ];

                array_push($results, $formated);
            }
        }
        if ($obj) {
            return json_decode(json_encode($results));
        }
        return $results;
    }
}

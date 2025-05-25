<?php

namespace App\Templators\V1;

use Carbon\Carbon;

class FlashPointTemplator
{
    public function template(array $data, $obj = false)
    {
        // foreach($data[1] as $test){

        // }
        $data = explode(';', $data[1][0]); //convert string to arr
        // Instrument data
        // $data[0]; header
        $formated = [
            "sample" => [
                "label" => $data[1],
                "timestamp" => Carbon::parse($data[0])->format('Y/m/d H:i:s'), //check time code (CEST to Local)
                "user" => $data[24],

            ],
            "instrument" => [
                "instrument" => 'flashpoint',
                "instrument_serial" => $data[23],
            ],

            "additional" => [
                "Air[ml]" => $data[2],
                "HeatRate[°C/min]" => $data[3],
                "IgnitionDuration[ms]" => $data[4],
                "test_standard" => $data[5], //ASTM etc
                "Step[°C]" => $data[6],
                "StirrerSpeed[U/min]" => $data[7],
                "Stirrer[]" => $data[8],
                "acceptedReferenceValue[]" => $data[12],
                "accuracyMonitoring" => $data[13],
                "chamberPressure[kPa]" => $data[14],
                "coldFilling[]" => $data[15],
                "deltaPlimit[kPa]" => $data[16],
                "deltaPmax[kPa]" => $data[17],
                "measurementNCycles[]" => $data[18],
                "passFailResult" => $data[19],
                "precautionIgnInterval[°C]" => $data[20],
                "publishedReproducibility[]" => $data[21],
                "qualityAssurance" => $data[22],
            ],
            "results" => [
                [
                    'label' => "Tf",
                    'value' => $data[9],
                    'unit' => '°C'
                ],
                [
                    'label' => "Tflash",
                    'value' => $data[10],
                    'unit' => '°C'
                ],
                [
                    'label' => "Ti",
                    'value' => $data[11],
                    'unit' => '°C'
                ],

            ]

        ];
        if ($obj) {
            return json_decode(json_encode($formated));
        }
        return $formated;
    }
}

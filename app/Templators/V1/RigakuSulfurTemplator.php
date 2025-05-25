<?php

namespace App\Templators\V1;

use Carbon\Carbon;

class RigakuSulfurTemplator
{
    public function template(array $data, $obj = false)
    {
        // Instrument data
        $formated = [
            "sample" => [
                'label' => $data[0][1],
                'timestamp' => $data[1][1],
            ],
            "instrument" => [
                'label' => $data[2][1],
            ],
            "additional" => [
                'application' => $data[3][1],
                'total_time' => $data[4][1],
                'region' => $data[11][0],
                'raw' => $data[11][1],
                'bg' => $data[11][2],
                'bg-cor' => $data[11][3],
                'x-cor' => $data[11][4],
                // $data[12] //isNull,
                // $data[13] //header,
                // $data[14][0] //duplicate of $data[11][0],
                'stdz' => $data[14][1],
                'zero' => $data[14][2],
                'net' => $data[14][3],
                // $data[15] //isNull,
                // $data[16] //header,
                'livetime' => $data[17][0],
                'bg_counts' => $data[17][1],
                'offset' => $data[17][2],
                'kevch' => $data[17][3],
                'noise' => $data[17][4],
                'resolution' => $data[17][5]
                // $data[19] //isNull,
                // $data[20] //isNull,
            ],
            'results' => [
                [
                    'label' => $data[7][0],
                    'value' => $data[7][1],
                    'unit' => ''
                ]
                // $data[8] //isNull,
                // $data[9] //isNull,
                // $data[10] //header,
            ],
        ];

        if ($obj) {
            return json_decode(json_encode($formated));
        }
        return $formated;
    }
}

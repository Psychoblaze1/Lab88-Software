<?php

namespace App\Traits;


trait DetectInstrumentTrait
{

    private $forLength = 5;



    public function detectInstrument($data)
    {
        /*
      get file first line
      check if is csv string
        - true, read csv lines
        - false, read string param and second line
      */
        $key = '';
        for ($i = 0; $i < $this->forLength; $i++) {

            if (!is_array($data[$i])) {
                // echo '!is_array <br>';

                $line = str_getcsv($data[$i]);
                if (count($line) > 1) {
                    dd($line, 'count > 1');
                } else {
                    // echo 'count < 1 <br>';
                    $key = $this->strHash($data[$i]);
                    if (array_key_exists($key, $this->library)) {
                        return $this->getInstrumentByKey($key);
                    } else {
                        dd($data, 'no key', 'detect instrument template');
                    }
                }
            } else {
                // echo 'is array <br>';
                $key = $this->strHash($data[$i][0]);
                if (array_key_exists($key, $this->library)) {
                    return $this->getInstrumentByKey($key);
                } else {
                    // echo $this->strHash($data[$i][0]);
                    dd($data[$i][0], 'no key');
                }
            }

            if (!array_key_exists($key, $this->library)) {
                dd($data[$i]);
            }
        }


        return $this->getInstrumentByKey($key);
    }

    private function getInstrumentByKey($key)
    {
        if (!array_key_exists($key, $this->library)) {
            dd($key, 'does not exist');
        }
        return $this->library[$key];
    }

    private function strHash($str)
    {
        $formattedStr = str_replace(' ', '_', strtolower($str));
        return hash('SHA256', $formattedStr);
    }
    private $library = [
        '0293b3b68ab230ac9bf6dda80ac51194fbb8d551354cd0f8f4cc4d63f7ca3953' => 'distilation',
        '5ef0fee6649b510241bd6378d40d95007bae8449b0ec1a165e9d7924ffa30899' => 'flashpoint',
        'e40506b6a349781d61794e1f8d4c04b26f492c9c697bdfdb459c8b08aade2760' => 'rigaku',
        '0e15c85f816db5e4c868abca8255b993b9b79bb7d2f000bbdca1dfa28e80263b' => 'aromatics',
    ];
}

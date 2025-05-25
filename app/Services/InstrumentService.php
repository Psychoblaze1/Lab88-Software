<?php

namespace App\Services;

use App\Actions\InstrumentActions;
use App\Models\TestParameter;
use App\Services\TestParameterService;
use App\Services\TestStandardService;
use App\Traits\DetectInstrumentTrait;
use Illuminate\Support\Facades\DB;
use App\Templators\V1\FlashPointTemplator;
use App\Templators\V1\SpectroAromatics;
use App\Templators\V1\RigakuSulfurTemplator;
use App\Templators\V1\DistilationTemplator;

class InstrumentService
{

    use DetectInstrumentTrait;

    protected $instrumentActions, $testParameterService, $testStandardService;
    public function __construct(InstrumentActions $instrumentActions, TestParameterService $testParameterService, TestStandardService $testStandardService)
    {
        $this->instrumentActions = $instrumentActions;
        $this->testParameterService = $testParameterService;
        $this->testStandardService = $testStandardService;
    }

    public function getInstruments()
    {
        return $this->instrumentActions->getInstruments();
    }

    public function firstOrCreate($data)
    {
        $instrument = $this->instrumentActions->firstOrCreate($data->name);
        if (isset($data->description)) {
            $instrument->description()->create(
                [
                    'content' => $data->description
                ]
            );
        }


        if (count($data->parameters) > 0) {
            foreach ($data->parameters as $param) {
                $parameter = TestParameter::firstOrCreate(['name' => $param->name]);

                DB::table('instruments_test_parameters')->insert(
                    [
                        'instrument_id' => $instrument->id,
                        'test_parameter_id' => $parameter->id
                    ]
                );
                // TestStandards
                foreach ($param->test_standards as $standard) {
                    $standard = $this->testStandardService->firstOrCreate($standard);

                    DB::table('instruments_test_standards')->insert(
                        [
                            'instrument_id' => $instrument->id,
                            'test_standard_id' => $standard->id
                        ]
                    );
                }
            }
        }



        return $instrument;
    }


    /*
    Get file
    check hash against DB
    - if exists, return notification
    - if !exists, continue
    get template for instrument
    - check ext
    - header info
    return data as standardised arr
    pass to sampleRepo->create
    */

    public function handleInstrumentSampleFileUpload($absolutePtf)
    {
        // $hash = $this->fileToHash($ptf);
        $fileData = $this->handleFileByExt($absolutePtf);

        return $this->getTemplateData($fileData);
    }
    private function getTemplateData($data)
    {
        $instrument = $this->detectInstrument($data);

        switch ($instrument) {
            case 'flashpoint':
                $flashTemplate = new FlashPointTemplator();
                return  $flashTemplate->template($data);
                break;
            case 'aromatics':
                // producing an error because its an arr of data points
                $aromatics = new SpectroAromatics(); // TODO: set condition to return multiple tests
                return  $aromatics->template($data);
                break;
            case 'rigaku':
                $rigakuTemplate = new RigakuSulfurTemplator();
                return $rigakuTemplate->template($data);
                break;
            case 'distilation':
                $distilationTemplate = new DistilationTemplator();
                return $distilationTemplate->template($data);
                break;
            default:
                return null;
        }
    }
    protected function handleFileByExt($absolutePtf)
    {
        $fileInfo = pathinfo($absolutePtf);
        $data = [];
        if (array_key_exists('extension', $fileInfo)) {

            switch ($fileInfo['extension']) {
                case "txt":
                    $data = $this->txtSampleToArr($absolutePtf);
                    break;
                case "csv":
                    $data = $this->csvSampleToArr($absolutePtf);
                    break;
            }
            return $data;
        } else {
            return $absolutePtf;
        }
    }
    private function txtSampleToArr($txtFile)
    {
        $arr = [];
        $txt_file = fopen($txtFile, 'r');

        while ($line = fgets($txt_file)) {
            $result = $this->removeUnprintableChars($line);
            $result = str_replace('"', '', $result);
            array_push($arr, $result);
        }
        fclose($txt_file);
        return $arr;
    }
    private function csvSampleToArr($csvFile)
    {
        return array_map('str_getcsv', $this->removeUnprintableChars(file($csvFile)));
    }
    public function removeUnprintableChars($string)
    {
        return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
    }
    private function fileToHash($file)
    {
        return hash_file(env('HASH'), $file);
    }
}

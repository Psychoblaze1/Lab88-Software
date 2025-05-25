<?php

namespace App\Services;

use App\Actions\FIleActions;
use App\Imports\V1\AnalysisClassImport;
use App\Imports\V1\InstrumentImport;
use App\Imports\V1\TestParameterCategoryImport;
use App\Imports\V1\TestParameterImport;
use App\Imports\V1\TestStandardImport;

class LibraryService
{
    protected $fileActions, $analysisClassImport, $instrumentImport, $testStandardImport, $testParameterImport, $testParameterCategoryImport;

    public function __construct(
        FileActions $fileActions,
        AnalysisClassImport $analysisClassImport,
        InstrumentImport $instrumentImport,
        TestStandardImport $testStandardImport,
        TestParameterImport $testParameterImport,
        TestParameterCategoryImport $testParameterCategoryImport,
    ) {
        $this->fileActions = $fileActions;
        $this->analysisClassImport = $analysisClassImport;
        $this->instrumentImport = $instrumentImport;
        $this->testStandardImport = $testStandardImport;
        $this->testParameterImport = $testParameterImport;
        $this->testParameterCategoryImport = $testParameterCategoryImport;
    }

    public function importLibraryFiles(string $dir)
    {
        // TODO: validate that the $dir path exists

        $files = $this->fileActions->getDirectoryContents($dir);

        // Loop through each file
        foreach ($files as $filename) {
            $pathToFile = $dir . '/' . $filename;
            // get File Contents from JSON to PHP Object
            $library =  json_decode(file_get_contents($pathToFile));
            // submit rows for importing
            $this->runImportTemplate($library->setup->model, $library->data);
        }
    }

    protected function runImportTemplate($modelName, $data)
    {
        switch ($modelName) {
            case 'AnalysisClass':
                $this->analysisClassImport->handle($data);
                break;
            case 'Instrument':
                $this->instrumentImport->handle($data);
                break;
            case 'TestStandard':
                $this->testStandardImport->handle($data);
                break;
            case 'TestParameter':
                $this->testParameterImport->handle($data);
                break;;
            default:
                return 'No Import Class Found';
        }
    }
}

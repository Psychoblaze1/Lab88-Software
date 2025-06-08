<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Component;
use App\Models\LimitParameter;
use App\Models\LimitSuite;
use App\Models\Sample;
use App\Models\SamplePoint;
use App\Models\SampleResult;
use App\Models\Site;
use App\Services\SampleService;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    protected $sampleService;

    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }

    public function registerSample(Request $request)
    {
        $data = json_decode(json_encode($request->get('formData')));
        $chainData = $data->chain;
        $sampleData = $data->sample;

        if (isset($sampleData->id)) {
            return   $this->updateExistingSample($sampleData, $chainData);
        }
        if (!isset($sampleData->id)) {
            return $this->createNewSample($sampleData, $chainData);
        }
    }

    public function updateExistingSample($sampleData, $chainData)
    {
        $sample = Sample::find($sampleData->id);
        if (!isset($sample)) {
            return 'no sample found';
        }
        $sample->account_id = $chainData->account_id;
        $sample->asset_chain_id = $chainData->sample_point->id;
        $sample->name = $sampleData->name;
        $sample->type = $sampleData->type;
        $sample->drawn_by = $sampleData->drawn_by;
        $sample->drawn_at = $sampleData->drawn_at;
        $sample->status = 1;
        $sample->save();

        return $sample;
    }

    public function createNewSample($sampleData, $chainData)
    {
        // $assetChain = $this->setAssetChain($chainData);
        return Sample::create([
            'account_id' => $chainData->account_id,
            'asset_chain_id' => $chainData->sample_point->id,
            'name' => $sampleData->name,
            'type' => $sampleData->type,
            'drawn_by' => $sampleData->drawn_by,
            'drawn_at' => $sampleData->drawn_at,
            'status' => 1
        ]);
    }

    public function setAssetChain($chainData)
    {

        $siteId = $chainData->site->id;
        if (!isset($siteId)) {
            $siteId = Site::create(
                [
                    'account_id' => $chainData->account_id,
                    'name' => $chainData->site->name
                ]
            )->id;
        }

        $assetId = $chainData->asset->id;
        if (!isset($assetId)) {
            $assetId = Asset::create(
                [
                    'account_id' => $chainData->account_id,
                    'site_id' => $siteId,
                    'name' => $chainData->asset->name
                ]
            )->id;
        }
        $componentId = $chainData->component->id;
        if (!isset($componentId)) {
            $componentId = Component::create(
                [
                    'asset_id' => $assetId,
                    'name' => $chainData->component->name
                ]
            )->id;
        }

        $sample_point_id = $chainData->sample_point->id;
        if (!isset($sample_point_id)) {
            $sample_point_id = SamplePoint::create(
                [
                    'component_id' => $componentId,
                    'name' => $chainData->sample_point->name
                ]
            )->id;
        }

        $assetChainData = [
            'account_id' => $chainData->account_id,
            'site_id' => $siteId,
            'asset_id' => $assetId,
            'component_id' => $componentId,
            'sample_point_id' => $sample_point_id,
        ];

        return json_decode(json_encode($assetChainData));
    }

    public function receiveSample(Request $request)
    {
        $data = json_decode(json_encode($request->get('data')));
        return $this->sampleService->receiveSample($data);
    }

    public function prepareSample(Request $request)
    {
        $data = json_decode(json_encode($request->get('formData')));
        $data = $data->formData;

        $parametersToTest = $data->parameters_to_test;
        $limitSuiteId = $data->limit_suite_id;

        $sample = Sample::find($data->sample_id);
        if (!isset($sample)) {
            return 'No Sample';
        }

        // Link limitSuite to sample
        if (isset($data->new_suite_name)) {

            $limitSuite = LimitSuite::create(['name' => $data->new_suite_name]);
            foreach ($parametersToTest as $paramToTest) {
                $limitSuite->limitParameters()->create(
                    [
                        'limit_suite_id' => $limitSuite->id,
                        'test_parameter_id' => $paramToTest->test_parameter_id,
                        'min' => $paramToTest->min,
                        'max' => $paramToTest->max,
                        'comparator' => $paramToTest->comparator,
                    ]
                );
            }
            $limitSuiteId = $limitSuite->id;
        }

        if (isset($limitSuiteId)) {
            $sample->limit_suite_id = $limitSuiteId;
        }

        $sample->status = 3;
        $sample->save();

        // PreLoad results and values from limit suite into SampleResults
        foreach ($parametersToTest as $paramToTest) {
            $sample->results()->firstOrCreate(
                [
                    'test_parameter_id' => $paramToTest->test_parameter_id,
                ],
                [
                    'min' => $paramToTest->min,
                    'max' => $paramToTest->max,
                    'comparator' => $paramToTest->comparator,
                ]
            );
        }
        // refresh
        return Sample::with('results')->where('id', $data->sample_id)->first();
    }

    public function testSample(Request $request)
    {
        $data = json_decode(json_encode($request->get('formData')));
        $data = $data->formData; // !!TODO: check where this is coming from ->formData

        $results = $data->results;

        $sample = Sample::with('results')->where('id', $data->sample_id)->first();
        if (!isset($sample)) {
            return 'No Sample';
        }
        // TODO: need to check if all parameters in LimitSuite are tested and then increment the sample
        foreach ($results as $result) {
            $sampleResult = SampleResult::where([
                'sample_id' => $data->sample_id,
                'test_parameter_id' => $result->test_parameter_id
            ])->first();

            $sampleResult->value = $result->value;
            $sampleResult->save();
        }

        // TEMP
        $sample->tested_by = $data->tested_by;
        $sample->tested_at = now();
        $sample->status = 4; //TODO: if complete, then next()
        $sample->save();

        return Sample::with('results')->where('id', $data->sample_id)->first();
    }

    public function validateSample(Request $request)
    {
        $data = json_decode(json_encode($request->get('formData')));
        $data = $data->formData; // !!TODO: check where this is coming from ->formData

        $sample = Sample::find($data->sample_id);
        if (!isset($sample)) {
            return 'No Sample';
        }
        $samplePassed = true;
        foreach ($data->results as $formResult) {
            $result = SampleResult::find($formResult->id);
            $result->pass = $formResult->pass;
            $result->validated = $formResult->validated;
            $result->save();

            if (!$formResult->pass) {
                $samplePassed = false;
            }
        }

        $sample->released_by = $data->released_by;
        $sample->released_at = now();
        $sample->conformity = $data->conformity;
        $sample->pass = $samplePassed;
        $sample->status = 5;
        $sample->save();
        return $sample;
    }

    public function getSample(Request $request)
    {
        return Sample::find($request->route('id'));
    }
    public function getSamples()
    {
        return $this->sampleService->getSamples();
    }

    public function deleteSample(Request $request)
    {
        $this->sampleService->deleteSample($request->get('sample_id'));
    }
}

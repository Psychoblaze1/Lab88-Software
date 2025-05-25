<?php

namespace App\Services;

use App\Actions\SampleActions;
use App\Actions\SampleResultActions;
use App\Models\Sample;

class SampleService

{
    protected $sampleActions, $sampleResultActions;

    public function __construct(SampleActions $sampleActions, SampleResultActions $sampleResultActions)
    {
        $this->sampleActions = $sampleActions;
        $this->sampleResultActions = $sampleResultActions;
    }

    public function deleteSample($sampleId)
    {
        return Sample::find($sampleId)->delete();
    }

    public function updateSampleStatus(Sample $sample, $incValue, $triggeredBy = 'system')
    {
        // Set new status
        $sample->changeStatus($incValue);
        // Set updated_at
        $sample->updatedAt();
        // Create log
        $sample->sampleStatusLogs()->create(
            [
                'status' => Sample::STATUS_LEVELS[$sample->status],
                'triggered_by' => $triggeredBy
            ]
        );
    }

    public function getSamples()
    {
        return Sample::with(['results'])->get();
    }

    public function registerSample()
    {
        // different methods to create Sample
    }

    public function receiveSample($data)
    {
        $sample = Sample::findOrFail($data->sample_id);
        // 
        if (!isset($sample)) {
            return $sample; //ERROR from FoF.
        }
        // LAB DETAILS
        $labId = null;
        if (isset($data->lab_id)) {
            $labId = $data->lab_id;
        };
        $sample->lab_id = $labId;
        // 
        $sample->received_at = $data->received_at;
        $sample->received_by = $data->received_by;
        $sample->status = 2;
        $sample->save();
        // 
        return $sample;
    }

    public function prepareSample()
    {
        // get testSuite.limits.parameters
    }

    public function allocateSample()
    {
        // allocate to lab instruments
    }

    public function testSample()
    {
        // get test results
    }

    public function validateSample()
    {
        // test against limit suite
    }

    public function approveSample()
    {
        // lab approves of final result
    }

    public function reportSample()
    {
        // create sample PDF
    }

    public function archiveSample()
    {
        // archive results and pdf after x time
        // get results as Csv / Excel
    }

    public function createSampleByAccount($account, string $name, string $limitSuiteId = null)
    {
        return $this->sampleActions->createSampleByAccount($account, $name, $limitSuiteId);
    }

    public function createResult($sample,  $testParamtereId, $value = null)
    {
        return $this->sampleResultActions->createResult($sample, $testParamtereId, $value);
    }

    public function getAllSampleResults(Sample $sample)
    {
        return $this->sampleActions->getAllSampleResults($sample);
    }

    public function getPendingSampleResults(Sample $sample)
    {
        return $this->sampleActions->getPendingSampleResults($sample);
    }

    public function getTestedSampleResults(Sample $sample)
    {
        return $this->sampleActions->getTestedSampleResults($sample);
    }
}

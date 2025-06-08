<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\Sample;
use App\Models\SampleStatusLog;

class SampleActions
{

    public function logStatusChange(Sample $sample, $triggeredBy)
    {
        return SampleStatusLog::create(
            [
                'sample_id' => $sample->id,
                'status' => $sample->status,
                'triggered_by' => $triggeredBy,
                'updated_at' => now(),
            ]
        );
    }

    public function createSampleByAccount(Account $account, $name, $limitSuiteId = null)
    {
        return $account->samples()->create(
            [
                'name' => $name,
                'limit_suite_id' => $limitSuiteId
            ]
        );
    }

    public function getAllSampleResults(Sample $sample)
    {
        return $sample->results()->get();
    }

    public function getPendingSampleResults(Sample $sample)
    {
        return $sample->results()->where(
            [
                'status' => 0,
            ]
        )->get();
    }

    public function getTestedSampleResults(Sample $sample)
    {
        return $sample->results()->where(
            [
                'status' => 1,
            ]
        )->get();
    }

    public function getStatus($status)
    {
        return Sample::STATUS_LEVELS[$status];
    }

    public function mapSamplesOutput($samples)
    {
        return $samples->map(function ($sample) {
            return [
                'id' => $sample->id,
                'account_id' => $sample->account_id,
                'asset_chain_id' => $sample->asset_chain_id,
                'name' => $sample->name,
                'status' => $sample->status,
                'type' => $sample->type,
                'drawn_by' => $sample->drawn_by,
                'drawn_at' => $sample->drawn_at,
                'location' => 'location chain'
            ];
        });
    }
}

<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleResult extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'comparator',
        'max',
        'min',
        'status',
        'test_parameter_id',
        'value',
    ];

    const STATUS_LEVELS = [
        'pending',
        'tested',
        'comparing',
        'complete'
    ];

    public function description() //change to notable
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function sample()
    {
        return $this->belongsTo(Sample::class);
    }

    public function limitParamter()
    {
        return $this->belongsTo(LimitParameter::class);
    }

    public function testParamter()
    {
        return $this->belongsTo(TestParameter::class);
    }

    public function getStatus()
    {
        return SampleResult::STATUS_LEVELS[$this->status];
    }
    public function changeStatus($amount)
    {
        $statusLevels = SampleResult::STATUS_LEVELS;
        $min = 0;
        $max = count($statusLevels) - 1;
        $currentStatus = $this->status;
        $newStatus = $currentStatus + $amount;

        if ($newStatus  >= $min && $newStatus <= $max) {
            $this->increment('status', $amount);
        }
    }
}

<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Sample extends Model
{
    use HasFactory, HasUuid, SoftDeletes, HasRelationships;
    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'type',
    //     'drawn_by',
    //     'drawn_at',
    //     'received_by',
    //     'received_at',
    //     'status',
    //     'account_id',
    //     'lab_id',
    //     'asset_chain_id',
    //     'limit_suite_id'
    // ];

    protected $hidden = [
        'deleted_at',
    ];

    // TODO: add descriptions
    const STATUS_LEVELS = [
        "register",
        "receive",
        "prepare",
        "test",
        "validate",
        "report",
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function limitSuite()
    {
        return $this->belongsTo(LimitSuite::class, 'limit_suite_id');
    }

    public function results()
    {
        return $this->hasMany(SampleResult::class);
    }

    public function testParameters()
    {
        return $this->hasManyDeep(TestParameter::class, [LimitSuite::class, LimitParameter::class]);
    }

    public function assetChain()
    {
        return $this->belongsTo(AssetChain::class, 'asset_chain_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(SampleStatusLog::class);
    }



    public function changeStatus($amount)
    {
        $statusLevels = Sample::STATUS_LEVELS;
        $min = 0;
        $max = count($statusLevels) - 1;
        $currentStatus = $this->status;
        $newStatus = $currentStatus + $amount;

        if ($newStatus  >= $min && $newStatus <= $max) {
            $this->increment('status', $amount);
        }
    }

    public function updatedAt()
    {
        $this->updated_at = now();
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function notes()
    {
        return $this->morphMany(Notable::class, 'notable');
    }
}

/*
TODO: sample revisions / consolodation : if the same sample number is created twice or edited, etc

*/

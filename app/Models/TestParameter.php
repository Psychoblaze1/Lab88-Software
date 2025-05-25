<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestParameter extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'name',
        'unit',
        'description',
    ];

    public function analysisClass()
    {
        return $this->belongsToMany(AnalysisClass::class);
    }

    public function category()
    {
        return $this->belongsTo(TestParameterCategory::class, 'category_id');
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'instrument_test_parameter');
    }

    public function pendingResults()
    {
        return $this->hasMany(PendingResult::class);
    }

    public function testStandards()
    {
        return $this->belongsToMany(TestStandard::class, 'test_parameters_test_standards');
    }
}

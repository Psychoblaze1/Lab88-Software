<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LimitParameter extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'test_parameter_id',
        'test_standard_id',
        'min',
        'max',
        'comparator',
    ];

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function limitSuite()
    {
        return $this->belongsTo(LimitSuite::class);
    }

    public function testParameter()
    {
        return $this->hasOne(TestParameter::class);
    }
}

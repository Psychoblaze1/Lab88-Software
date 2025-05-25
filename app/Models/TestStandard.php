<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestStandard extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'instruments_test_standards');
    }

    public function testParameters()
    {
        return $this->belongsToMany(TestParameter::class, 'test_standards_test_parameters');
    }

    public function notes()
    {
        return $this->morphMany(Notable::class, 'notable');
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}

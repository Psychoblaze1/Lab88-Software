<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory, HasUuid;

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function labs()
    {
        return $this->belongsToMany(Lab::class, 'instrument_lab');
    }

    public function testStandards()
    {
        return $this->belongsToMany(TestStandard::class, 'instruments_test_standards');
    }

    public function testParameters()
    {
        return $this->belongsToMany(TestParameter::class, 'instruments_test_parameters');
    }
}

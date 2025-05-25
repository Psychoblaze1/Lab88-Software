<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LimitSuite extends Model
{
    use HasFactory, HasUuid, SoftDeletes;
    protected $fillable = [
        'name',
        'description'
    ];

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function limitParameters()
    {
        return $this->hasMany(LimitParameter::class);
    }

    public function testParamters()
    {
        return $this->hasMany(TestParameter::class);
    }
}

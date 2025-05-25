<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingResult extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function sample()
    {
        return $this->belongsTo(Sample::class);
    }

    public function testParameter()
    {
        return $this->belongsTo(TestParameter::class);
    }
}

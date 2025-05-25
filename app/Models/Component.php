<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'name',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function samplePoints()
    {
        return $this->hasMany(SamplePoint::class);
    }
}

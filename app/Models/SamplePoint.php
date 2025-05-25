<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SamplePoint extends Model
{
    use HasFactory, HasUuid, SoftDeletes;


    protected $fillable = [
        'component_id',
        'name',
    ];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function notes()
    {
        return $this->morphMany(Notable::class, 'notable');
    }

    public function sample()
    {
        return $this->hasOne(Sample::class);
    }
}

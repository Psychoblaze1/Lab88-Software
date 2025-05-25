<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'instrument_lab');
    }

    public function samples()
    {
        return $this->hasMany(Sample::class);
    }
}

<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'account_id',
        'site_id',
        'name',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }
}

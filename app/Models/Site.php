<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'account_id',
        'name',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function description()
    {
        return $this->morphOne(Describable::class, 'describable');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function notes()
    {
        return $this->morphMany(Notable::class, 'notable');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}

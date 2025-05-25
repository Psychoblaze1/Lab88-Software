<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetChain extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->child()->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}

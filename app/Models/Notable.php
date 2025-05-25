<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notable extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'content'
    ];

    public function notable()
    {
        return $this->morphTo();
    }
}

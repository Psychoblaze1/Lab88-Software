<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Describable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content'
    ];

    public function describable()
    {
        return $this->morphTo();
    }
}

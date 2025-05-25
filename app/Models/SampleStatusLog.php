<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleStatusLog extends Model
{
    use HasFactory;

    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }
}

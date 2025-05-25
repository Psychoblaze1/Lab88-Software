<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

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
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function labs()
    {
        return $this->hasMany(Lab::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function samples()
    {
        return $this->hasMany(Sample::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Period extends Model
{
    protected $fillable = ['year', 'month', 'name'];

    public function getFormattedAttribute()
    {
        return $this->name;
    }

    public function target()
    {
        return $this->hasMany(Target::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['image', 'name', 'price', 'stock'];

    public function target()
    {
        return $this->hasMany(Target::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}

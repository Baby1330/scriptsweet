<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function divisions() {
        return $this->hasMany(Division::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function clients() {
        return $this->hasMany(Client::class);
    }
}

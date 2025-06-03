<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function division() {
        return $this->belongsTo(Division::class);
    }

    public function users() {
        return $this->HasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'company_id',
        'division_id',
        'phone',
    ];
    
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function division() {
        return $this->belongsTo(Division::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

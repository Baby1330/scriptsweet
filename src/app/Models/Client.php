<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'phone',
        'branch_id',
        'division_id',
        // tambahkan field lain yang ingin kamu izinkan
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

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

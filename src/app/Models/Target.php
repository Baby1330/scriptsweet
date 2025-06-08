<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Target extends Model
{
    protected $fillable = [
        'company_id',
        'period_id',
        'branch_id',
        'product_id',
        'targetprod',
        'total',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function period(){
        return $this->belongsTo(Period::class);
    }
}

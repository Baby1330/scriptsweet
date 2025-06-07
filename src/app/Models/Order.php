<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'status',
        'product_id',
        'employee_id',
        'client_id',
        'qty',
        'grand_total',
        'order_code',
    ];

    // protected static function booted(): void
    // {
    //     static::creating(function (Order $order) {
    //         $prefix = strtoupper($order->status) === 'SO' ? 'SO' : 'PO';

    //         $lastOrder = static::where('order_code', 'like', "$prefix-%")->latest('id')->first();

    //         if ($lastOrder && preg_match('/\d+$/', $lastOrder->order_code, $matches)) {
    //             $number = (int) $matches[0] + 1;
    //         } else {
    //             $number = 1;
    //         }

    //         $order->order_code = $prefix . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    //     });
    // }

    public function client(){
        return $this->belongsTo(Client::class);
    }
        
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

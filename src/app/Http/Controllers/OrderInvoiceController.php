<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderInvoiceController extends Controller
{
    public function invoice(Order $order)
    {
        $pdf = Pdf::loadView('pdf.order-invoice', compact('order'));
        return $pdf->download('invoice_' . $order->order_code . '.pdf');
    }
}

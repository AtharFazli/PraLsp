<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function checkout(Request $request)
    {
        // Additional logic for handling the checkout process
        // ...

        // Prepare data for PDF
        $orderData = [
            'cart' => $request->input('cart'),
            'total' => $request->input('orderData.total'),
            'discount' => $request->input('orderData.discount'),
            'paymentMethod' => $request->input('orderData.paymentMethod'),
        ];

        // Calculate discounted total price
        $discountedTotal = $orderData['total'] - $orderData['discount'];

        // Generate PDF using Dompdf
        $pdf = PDF::loadView('dashboard.barang.checkout', compact('orderData', 'discountedTotal'));

        // Return the path to the generated PDF
        return $pdf->stream('checkout.pdf');
    }
}

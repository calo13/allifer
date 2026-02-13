<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function printDocument($saleId)
    {
        $sale = Sale::with(['items', 'customer', 'user'])->findOrFail($saleId);

        $pdf = Pdf::loadView('admin.pos.document', compact('sale'));
        
        return $pdf->stream('venta-' . $sale->folio . '.pdf');
    }
}
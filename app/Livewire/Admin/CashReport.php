<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashReport extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $efectivo_real = 0;

    // Totales
    public $total_efectivo = 0;
    public $total_tarjeta = 0;
    public $total_transferencia = 0;
    public $total_general = 0;

    // Por vendedor
    public $ventas_por_vendedor = [];

    // Productos más vendidos
    public $productos_mas_vendidos = [];

    public $numero_ventas = 0;

    public function mount()
    {
        // Por defecto, mostrar el día de hoy
        $this->fecha_inicio = Carbon::today()->format('Y-m-d');
        $this->fecha_fin = Carbon::today()->format('Y-m-d');
        $this->calcularReporte();
    }

    public function setRangoHoy()
    {
        $this->fecha_inicio = Carbon::today()->format('Y-m-d');
        $this->fecha_fin = Carbon::today()->format('Y-m-d');
        $this->calcularReporte();
    }

    public function setRangoAyer()
    {
        $this->fecha_inicio = Carbon::yesterday()->format('Y-m-d');
        $this->fecha_fin = Carbon::yesterday()->format('Y-m-d');
        $this->calcularReporte();
    }

    public function setRangoSemana()
    {
        $this->fecha_inicio = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->endOfWeek()->format('Y-m-d');
        $this->calcularReporte();
    }

    public function setRangoMes()
    {
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->calcularReporte();
    }

    public function calcularReporte()
    {
        $inicio = Carbon::parse($this->fecha_inicio)->startOfDay();
        $fin = Carbon::parse($this->fecha_fin)->endOfDay();

        // Total por método de pago
        $ventas = Sale::whereBetween('created_at', [$inicio, $fin])->get();

        $this->total_efectivo = $ventas->where('metodo_pago', 'efectivo')->sum('total');
        $this->total_tarjeta = $ventas->where('metodo_pago', 'tarjeta')->sum('total');
        $this->total_transferencia = $ventas->where('metodo_pago', 'transferencia')->sum('total');
        $this->total_general = $ventas->sum('total');
        $this->numero_ventas = $ventas->count();

        // Ventas por vendedor
        $this->ventas_por_vendedor = Sale::select('user_id', DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as cantidad'))
            ->whereBetween('created_at', [$inicio, $fin])
            ->groupBy('user_id')
            ->with('user')
            ->get()
            ->map(function ($venta) {
                return [
                    'nombre' => $venta->user->name ?? 'Sin usuario',
                    'total' => $venta->total,
                    'cantidad' => $venta->cantidad,
                ];
            })
            ->toArray();

        // Productos más vendidos
        $this->productos_mas_vendidos = SaleItem::select('product_id', 'product_name', DB::raw('SUM(quantity) as total_vendido'), DB::raw('SUM(subtotal) as ingresos'))
            ->whereHas('sale', function ($query) use ($inicio, $fin) {
                $query->whereBetween('created_at', [$inicio, $fin]);
            })
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function exportExcel()
    {
        $this->calcularReporte();

        return response()->streamDownload(function () {
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
                    th, td { border: 1px solid #000000; padding: 5px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    .header { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 20px; }
                    .section { font-weight: bold; margin-top: 20px; margin-bottom: 10px; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class="header">Reporte de Caja</div>
                <p>Período: ' . date('d/m/Y', strtotime($this->fecha_inicio)) . ' - ' . date('d/m/Y', strtotime($this->fecha_fin)) . '</p>
                
                <div class="section">Resumen Financiero</div>
                <table>
                    <thead>
                        <tr>
                            <th>Total General</th>
                            <th>Efectivo</th>
                            <th>Tarjeta</th>
                            <th>Transferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Q ' . number_format($this->total_general, 2) . '</td>
                            <td>Q ' . number_format($this->total_efectivo, 2) . '</td>
                            <td>Q ' . number_format($this->total_tarjeta, 2) . '</td>
                            <td>Q ' . number_format($this->total_transferencia, 2) . '</td>
                        </tr>
                    </tbody>
                </table>

                <div class="section">Control de Efectivo</div>
                <table>
                    <thead>
                        <tr>
                            <th>Efectivo Esperado</th>
                            <th>Efectivo Real</th>
                            <th>Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Q ' . number_format($this->total_efectivo, 2) . '</td>
                            <td>Q ' . number_format($this->efectivo_real, 2) . '</td>
                            <td style="color: ' . (($this->efectivo_real - $this->total_efectivo) < 0 ? 'red' : 'green') . ';">
                                Q ' . number_format($this->efectivo_real - $this->total_efectivo, 2) . '
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="section">Ventas por Vendedor</div>
                <table>
                    <thead>
                        <tr>
                            <th>Vendedor</th>
                            <th>Cantidad Ventas</th>
                            <th>Total Facturado</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($this->ventas_por_vendedor as $venta) {
                echo '<tr>
                    <td>' . $venta['nombre'] . '</td>
                    <td>' . $venta['cantidad'] . '</td>
                    <td>Q ' . number_format($venta['total'], 2) . '</td>
                </tr>';
            }

            echo '</tbody>
                </table>

                <div class="section">Top 10 Productos Más Vendidos</div>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad Vendida</th>
                            <th>Ingresos Generados</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($this->productos_mas_vendidos as $producto) {
                echo '<tr>
                    <td>' . $producto['product_name'] . '</td>
                    <td>' . $producto['total_vendido'] . '</td>
                    <td>Q ' . number_format($producto['ingresos'], 2) . '</td>
                </tr>';
            }

            echo '</tbody>
                </table>
            </body>
            </html>';
        }, 'reporte-caja-' . date('Y-m-d') . '.xls');
    }

    public function exportPdf()
    {
        $this->calcularReporte();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cash-report.pdf', [
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'total_general' => $this->total_general,
            'total_efectivo' => $this->total_efectivo,
            'total_tarjeta' => $this->total_tarjeta,
            'total_transferencia' => $this->total_transferencia,
            'efectivo_real' => $this->efectivo_real,
            'ventas_por_vendedor' => $this->ventas_por_vendedor,
            'productos_mas_vendidos' => $this->productos_mas_vendidos,
        ]);

        // $pdf->setPaper('a4', 'portrait'); // Default

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'reporte-caja-' . date('Y-m-d') . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.cash-report');
    }
}

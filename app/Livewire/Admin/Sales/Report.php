<?php

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use App\Models\SaleItem;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Report extends Component
{
    public $filterFechaInicio;
    public $filterFechaFin;
    public $filterPeriodo = 'hoy';

    public function mount()
    {
        $this->filterFechaInicio = now()->startOfDay()->format('Y-m-d');
        $this->filterFechaFin = now()->endOfDay()->format('Y-m-d');
    }

    public function setPeriodo($periodo)
    {
        $this->filterPeriodo = $periodo;
        
        switch ($periodo) {
            case 'hoy':
                $this->filterFechaInicio = now()->startOfDay()->format('Y-m-d');
                $this->filterFechaFin = now()->endOfDay()->format('Y-m-d');
                break;
            case 'ayer':
                $this->filterFechaInicio = now()->subDay()->startOfDay()->format('Y-m-d');
                $this->filterFechaFin = now()->subDay()->endOfDay()->format('Y-m-d');
                break;
            case 'semana':
                $this->filterFechaInicio = now()->startOfWeek()->format('Y-m-d');
                $this->filterFechaFin = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'mes':
                $this->filterFechaInicio = now()->startOfMonth()->format('Y-m-d');
                $this->filterFechaFin = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'ano':
                $this->filterFechaInicio = now()->startOfYear()->format('Y-m-d');
                $this->filterFechaFin = now()->endOfYear()->format('Y-m-d');
                break;
        }
    }

    public function render()
    {
        // Validar fechas
        if (empty($this->filterFechaInicio) || empty($this->filterFechaFin)) {
            return view('livewire.admin.sales.report', [
                'sales' => collect(),
                'totalVentas' => 0,
                'totalCostos' => 0,
                'totalGanancias' => 0,
                'margenGanancia' => 0,
                'productosVendidos' => collect(),
                'ventasPorDia' => collect(),
            ]);
        }

        // Obtener ventas del período
        $sales = Sale::whereBetween('fecha_venta', [
                $this->filterFechaInicio . ' 00:00:00',
                $this->filterFechaFin . ' 23:59:59'
            ])
            ->with('items')
            ->get();

        // Calcular totales
        $totalVentas = $sales->sum('total');
        $totalCostos = 0;
        $totalGanancias = 0;

        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $costoTotal = $item->precio_costo * $item->quantity;
                $ventaTotal = $item->precio_unitario * $item->quantity;
                $totalCostos += $costoTotal;
                $totalGanancias += ($ventaTotal - $costoTotal);
            }
        }

        // Margen de ganancia
        $margenGanancia = $totalVentas > 0 ? ($totalGanancias / $totalVentas) * 100 : 0;

        // Productos más vendidos
        $productosVendidos = SaleItem::select('product_name', DB::raw('SUM(quantity) as total_vendido'))
            ->whereHas('sale', function ($query) {
                $query->whereBetween('fecha_venta', [
                    $this->filterFechaInicio . ' 00:00:00',
                    $this->filterFechaFin . ' 23:59:59'
                ]);
            })
            ->groupBy('product_name')
            ->orderBy('total_vendido', 'desc')
            ->limit(5)
            ->get();

        // Ventas por día
        $ventasPorDia = Sale::select(
                DB::raw('DATE(fecha_venta) as fecha'),
                DB::raw('COUNT(*) as total_ventas'),
                DB::raw('SUM(total) as total_monto')
            )
            ->whereBetween('fecha_venta', [
                $this->filterFechaInicio . ' 00:00:00',
                $this->filterFechaFin . ' 23:59:59'
            ])
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('livewire.admin.sales.report', [
            'sales' => $sales,
            'totalVentas' => $totalVentas,
            'totalCostos' => $totalCostos,
            'totalGanancias' => $totalGanancias,
            'margenGanancia' => $margenGanancia,
            'productosVendidos' => $productosVendidos,
            'ventasPorDia' => $ventasPorDia,
        ]);
    }
}
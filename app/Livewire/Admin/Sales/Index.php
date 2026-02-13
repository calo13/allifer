<?php

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterTipoDocumento = '';
    public $filterMetodoPago = '';
    public $filterFechaInicio = '';
    public $filterFechaFin = '';

    protected $queryString = ['search', 'filterTipoDocumento', 'filterMetodoPago', 'filterFechaInicio', 'filterFechaFin'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getSalesQuery()
    {
        return Sale::query()
            ->with(['customer', 'user', 'items'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('folio', 'like', '%' . $this->search . '%')
                        ->orWhere('nombre_cliente', 'like', '%' . $this->search . '%')
                        ->orWhere('nit_cliente', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterTipoDocumento, function ($query) {
                $query->where('tipo_documento', $this->filterTipoDocumento);
            })
            ->when($this->filterMetodoPago, function ($query) {
                $query->where('metodo_pago', $this->filterMetodoPago);
            })
            ->when($this->filterFechaInicio, function ($query) {
                $query->whereDate('fecha_venta', '>=', $this->filterFechaInicio);
            })
            ->when($this->filterFechaFin, function ($query) {
                $query->whereDate('fecha_venta', '<=', $this->filterFechaFin);
            })
            ->latest('fecha_venta');
    }

    public function exportExcel()
    {
        $sales = $this->getSalesQuery()->get();

        return response()->streamDownload(function () use ($sales) {
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #000000; padding: 5px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                </style>
            </head>
            <body>
                <table>
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>NIT</th>
                            <th>Documento</th>
                            <th>Método Pago</th>
                            <th>Items</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($sales as $sale) {
                echo '<tr>
                    <td>' . $sale->folio . '</td>
                    <td>' . $sale->fecha_venta->format('d/m/Y H:i') . '</td>
                    <td>' . $sale->nombre_cliente . '</td>
                    <td>' . $sale->nit_cliente . '</td>
                    <td>' . ucfirst($sale->tipo_documento) . '</td>
                    <td>' . ucfirst($sale->metodo_pago) . '</td>
                    <td>' . $sale->items->count() . '</td>
                    <td>Q ' . number_format($sale->total, 2) . '</td>
                </tr>';
            }

            echo '</tbody>
                </table>
            </body>
            </html>';
        }, 'ventas-' . date('Y-m-d') . '.xls');
    }

    public function exportPdf()
    {
        $sales = $this->getSalesQuery()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.sales.pdf', ['sales' => $sales]);
        $pdf->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'ventas-' . date('Y-m-d') . '.pdf');
    }

    public function render()
    {
        $sales = $this->getSalesQuery()->paginate(15);

        // Estadísticas
        $stats = [
            'total_ventas_hoy' => Sale::whereDate('fecha_venta', today())->count(),
            'monto_ventas_hoy' => Sale::whereDate('fecha_venta', today())->sum('total'),
            'total_ventas_mes' => Sale::whereMonth('fecha_venta', now()->month)->count(),
            'monto_ventas_mes' => Sale::whereMonth('fecha_venta', now()->month)->sum('total'),
        ];

        return view('livewire.admin.sales.index', [
            'sales' => $sales,
            'stats' => $stats,
        ]);
    }
}

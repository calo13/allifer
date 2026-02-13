<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    // KPIs
    public $ventas_hoy = 0;
    public $ventas_ayer = 0;
    public $ganancias_hoy = 0;
    public $transacciones_hoy = 0;
    public $ticket_promedio = 0;
    public $margen_ganancia = 0;

    // Comparativas
    public $cambio_ventas = 0;

    // Ventas última semana (para gráfica)
    public $ventas_semana = [];
    public $labels_semana = [];

    // Métodos de pago
    public $ventas_efectivo = 0;
    public $ventas_tarjeta = 0;
    public $ventas_transferencia = 0;

    // Top productos
    public $top_productos = [];

    // Stock bajo
    public $productos_stock_bajo = [];

    // Top Clientes
    public $top_clientes = [];

    // Pedidos pendientes (Action Center)
    public $ordenes_pendientes = [];

    // Contadores básicos
    public $total_productos = 0;
    public $total_categorias = 0;
    public $total_marcas = 0;
    public $total_proveedores = 0;
    public $productos_activos = 0;

    public function mount()
    {
        $this->calcularKPIs();
        $this->calcularVentasSemana();
        $this->calcularMetodosPago();
        $this->calcularTopProductos();
        $this->calcularTopClientes();
        $this->calcularStockBajo();
        $this->calcularContadores();
        $this->fetchOrdenesPendientes();
    }

    public function fetchOrdenesPendientes()
    {
        $this->ordenes_pendientes = \App\Models\Order::where('estado', 'pendiente')
            ->latest()
            ->take(5)
            ->get();
    }

    public function calcularKPIs()
    {
        $hoy = Carbon::today();
        $ayer = Carbon::yesterday();

        // --- VENTAS HOY (POS + ONLINE) ---
        $ventas_pos_hoy = Sale::whereDate('created_at', $hoy)->sum('total');
        // Para online consideramos: aprobado, en_proceso, enviado, entregado (excluimos pendiente/cancelado)
        $ventas_web_hoy = \App\Models\Order::whereDate('created_at', $hoy)
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->sum('total');

        $this->ventas_hoy = $ventas_pos_hoy + $ventas_web_hoy;

        // --- VENTAS AYER ---
        $ventas_pos_ayer = Sale::whereDate('created_at', $ayer)->sum('total');
        $ventas_web_ayer = \App\Models\Order::whereDate('created_at', $ayer)
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->sum('total');

        $this->ventas_ayer = $ventas_pos_ayer + $ventas_web_ayer;

        // --- TRANSACCIONES ---
        $trans_pos = Sale::whereDate('created_at', $hoy)->count();
        $trans_web = \App\Models\Order::whereDate('created_at', $hoy)
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->count();

        $this->transacciones_hoy = $trans_pos + $trans_web;

        // --- CAMBIO PORCENTUAL ---
        if ($this->ventas_ayer > 0) {
            $this->cambio_ventas = (($this->ventas_hoy - $this->ventas_ayer) / $this->ventas_ayer) * 100;
        }

        // --- TICKET PROMEDIO ---
        if ($this->transacciones_hoy > 0) {
            $this->ticket_promedio = $this->ventas_hoy / $this->transacciones_hoy;
        }

        // --- GANANCIAS (Aprox) ---
        // Nota: Para orders no tenemos costo exacto aun en esta logica simple, 
        // usaremos un margen estimado del 30% si no hay datos, o solo costos de POS.
        // Por consistencia con la logica anterior, calcularemos ganancia exacta POS e ignoraremos el costo Web
        // O mejor: Calculamos ganancia solo de lo que tenemos certeza (POS) y asumimos margen en Web

        $items_pos = SaleItem::whereHas('sale', function ($q) use ($hoy) {
            $q->whereDate('created_at', $hoy);
        })->get();

        $costo_pos = $items_pos->sum(function ($item) {
            return $item->precio_costo * $item->quantity;
        });

        // Ganancia POS
        $ganancia_pos = $ventas_pos_hoy - $costo_pos;

        // Ganancia Web (Estimada 20% si no hay costo registrado, para no dejar en 0)
        // Idealmente deberiamos tener costo en OrderItem tambien.
        $ganancia_web = $ventas_web_hoy * 0.20;

        $this->ganancias_hoy = $ganancia_pos + $ganancia_web;

        if ($this->ventas_hoy > 0) {
            $this->margen_ganancia = ($this->ganancias_hoy / $this->ventas_hoy) * 100;
        }
    }

    public function calcularVentasSemana()
    {
        $ventas = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::today()->subDays($i);

            $total_pos = Sale::whereDate('created_at', $fecha)->sum('total');
            $total_web = \App\Models\Order::whereDate('created_at', $fecha)
                ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
                ->sum('total');

            $ventas[] = (float) ($total_pos + $total_web);
            $labels[] = $fecha->format('d M');
        }

        $this->ventas_semana = $ventas;
        $this->labels_semana = $labels;
    }

    public function calcularMetodosPago()
    {
        $hoy = Carbon::today();

        // POS
        $pos_efectivo = Sale::whereDate('created_at', $hoy)->where('metodo_pago', 'efectivo')->sum('total');
        $pos_tarjeta = Sale::whereDate('created_at', $hoy)->where('metodo_pago', 'tarjeta')->sum('total');
        $pos_transf = Sale::whereDate('created_at', $hoy)->where('metodo_pago', 'transferencia')->sum('total');

        // Web (Orders)
        // Mapeo: Web suele usar 'card' o 'transfer'. Asumiremos:
        // 'card' -> tarjeta
        // 'transferencia' -> transferencia
        // 'cash_on_delivery' -> efectivo

        $web_efectivo = \App\Models\Order::whereDate('created_at', $hoy)
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->where('metodo_pago', 'contra_entrega')->sum('total');

        $web_tarjeta = \App\Models\Order::whereDate('created_at', $hoy)
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->where('metodo_pago', 'tarjeta')->sum('total'); // stripe/etc

        $web_transf = \App\Models\Order::whereDate('created_at', $hoy)
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->where('metodo_pago', 'transferencia')->sum('total');

        $this->ventas_efectivo = (float) ($pos_efectivo + $web_efectivo);
        $this->ventas_tarjeta = (float) ($pos_tarjeta + $web_tarjeta);
        $this->ventas_transferencia = (float) ($pos_transf + $web_transf);
    }

    public function calcularTopProductos()
    {
        // Unificar POS y Web
        // Esto es un poco complejo en Eloquent puro sin una vista SQL
        // Haremos una aproximación: Sacamos Top 5 POS y Top 5 Web, mergeamos y reordenamos

        $hoy = Carbon::today();

        $top_pos = SaleItem::select('product_name', DB::raw('SUM(quantity) as total'))
            ->whereHas('sale', fn($q) => $q->whereDate('created_at', $hoy))
            ->groupBy('product_name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $top_web = \App\Models\OrderItem::select('product_name', DB::raw('SUM(quantity) as total'))
            ->whereHas('order', fn($q) => $q->whereDate('created_at', $hoy)
                ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado']))
            ->groupBy('product_name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Merge manual
        $merged = collect();

        foreach ($top_pos as $item) {
            $merged->push(['name' => $item->product_name, 'total' => $item->total, 'source' => 'pos']);
        }

        foreach ($top_web as $item) {
            // Check si ya existe
            $existing = $merged->firstWhere('name', $item->product_name);
            if ($existing) {
                // Actualizar total (hacky because collection items are arrays)
                $merged = $merged->map(function ($val) use ($item) {
                    if ($val['name'] === $item->product_name) {
                        $val['total'] += $item->total;
                    }
                    return $val;
                });
            } else {
                $merged->push(['name' => $item->product_name, 'total' => $item->total, 'source' => 'web']);
            }
        }

        $this->top_productos = $merged->sortByDesc('total')->take(5)->map(function ($item) {
            return [
                'product_name' => $item['name'],
                'total' => (int) $item['total']
            ];
        })->values()->toArray();
    }

    public function calcularTopClientes()
    {
        // Clientes Mas Frecuentes (Histórico, para que sea interesante)
        // Tomamos Top 5 POS (Customer) y Top 5 Web (User)

        $top_pos = Sale::select('customer_id', DB::raw('count(*) as total_sales'), DB::raw('sum(total) as total_spent'))
            ->whereNotNull('customer_id')
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        $top_web = \App\Models\Order::select('user_id', DB::raw('count(*) as total_sales'), DB::raw('sum(total) as total_spent'))
            ->whereNotNull('user_id')
            ->whereIn('estado', ['aprobado', 'en_proceso', 'enviado', 'entregado'])
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        $this->top_clientes = [
            'pos' => $top_pos,
            'web' => $top_web
        ];
    }

    public function calcularStockBajo()
    {
        $this->productos_stock_bajo = Product::whereRaw('stock <= stock_minimo')
            ->where('active', true)
            ->limit(5)
            ->get();
    }

    public function calcularContadores()
    {
        $this->total_productos = Product::count();
        $this->productos_activos = Product::where('active', true)->count();
        $this->total_categorias = Category::count();
        $this->total_marcas = Brand::count();
        $this->total_proveedores = Supplier::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Control de Stock</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .kpi-container {
            margin-bottom: 20px;
        }

        .kpi-table {
            width: 100%;
        }

        .kpi-card {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            background: #fff;
        }

        .kpi-title {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }

        .kpi-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Tienda Virtual - Control de Stock</h1>
        <p>Fecha: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="kpi-container">
        <div class="section-title">Resumen de Inventario</div>
        <table class="kpi-table">
            <tr>
                <td class="kpi-card">
                    <div class="kpi-title">Valor Total (Costo)</div>
                    <div class="kpi-value">Q {{ number_format($totalInventoryCost, 2) }}</div>
                </td>
                <td class="kpi-card">
                    <div class="kpi-title">Valor Total (Venta)</div>
                    <div class="kpi-value">Q {{ number_format($totalInventoryPrice, 2) }}</div>
                </td>
                <td class="kpi-card">
                    <div class="kpi-title">Productos Bajo Stock</div>
                    <div class="kpi-value" style="color: #dc2626;">{{ $lowStockCount }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- PRODUCTOS -->
    <div class="section-title">Detalle de Productos</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>SKU</th>
                <th>Costo</th>
                <th>Venta</th>
                <th>Stock</th>
                <th>Mínimo</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>Q {{ number_format($product->precio_costo, 2) }}</td>
                <td>Q {{ number_format($product->precio_venta, 2) }}</td>
                <td style="{{ $product->stock <= $product->stock_minimo ? 'color: red; font-weight: bold;' : '' }}">
                    {{ $product->stock }}
                </td>
                <td>{{ $product->stock_minimo }}</td>
                <td>Q {{ number_format($product->stock * $product->precio_costo, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- PRODUCTOS CON VARIANTES -->
    @if(count($productsWithVariants) > 0)
    <div class="section-title" style="margin-top: 20px;">Productos con Variantes</div>
    <table>
        <thead>
            <tr>
                <th>Producto Principal</th>
                <th>Variante (Tipo - Valor)</th>
                <th>Stock</th>
                <th>Costo Unitario (Base)</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productsWithVariants as $product)
            @foreach($product->variants as $variant)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $variant->type }} - {{ $variant->value }}</td>
                <td>{{ $variant->stock }}</td>
                <td>Q {{ number_format($product->precio_costo, 2) }}</td>
                <td>Q {{ number_format($variant->stock * $product->precio_costo, 2) }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>
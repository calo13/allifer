<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Caja</title>
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

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
            color: #333;
            margin-top: 20px;
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

        .kpi-table {
            margin-bottom: 20px;
        }

        .kpi-card {
            background: #f9f9f9;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .kpi-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .kpi-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Tienda Virtual - Reporte de Caja</h1>
        <p>Período: {{ date('d/m/Y', strtotime($fecha_inicio)) }} - {{ date('d/m/Y', strtotime($fecha_fin)) }}</p>
        <p>Generado: {{ date('d/m/Y H:i') }}</p>
    </div>

    <!-- RESUMEN -->
    <div class="section-title">Resumen Financiero</div>
    <table class="kpi-table">
        <tr>
            <td class="kpi-card">
                <div class="kpi-value">Q {{ number_format($total_general, 2) }}</div>
                <div class="kpi-label">Total General</div>
            </td>
            <td class="kpi-card">
                <div class="kpi-value">Q {{ number_format($total_efectivo, 2) }}</div>
                <div class="kpi-label">Efectivo</div>
            </td>
            <td class="kpi-card">
                <div class="kpi-value">Q {{ number_format($total_tarjeta, 2) }}</div>
                <div class="kpi-label">Tarjeta</div>
            </td>
            <td class="kpi-card">
                <div class="kpi-value">Q {{ number_format($total_transferencia, 2) }}</div>
                <div class="kpi-label">Transferencia</div>
            </td>
        </tr>
    </table>

    <!-- EFECTIVO -->
    <div class="section-title">Control de Efectivo</div>
    <table>
        <tr>
            <th>Efectivo Esperado</th>
            <th>Efectivo Real</th>
            <th>Diferencia</th>
        </tr>
        <tr>
            <td>Q {{ number_format($total_efectivo, 2) }}</td>
            <td>Q {{ number_format($efectivo_real, 2) }}</td>
            <td style="color: {{ ($efectivo_real - $total_efectivo) < 0 ? 'red' : 'green' }}; font-weight: bold;">
                Q {{ number_format($efectivo_real - $total_efectivo, 2) }}
            </td>
        </tr>
    </table>

    <!-- VENTAS POR VENDEDOR -->
    <div class="section-title">Ventas por Vendedor</div>
    <table>
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Cantidad Ventas</th>
                <th>Total Facturado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas_por_vendedor as $venta)
            <tr>
                <td>{{ $venta['nombre'] }}</td>
                <td>{{ $venta['cantidad'] }}</td>
                <td>Q {{ number_format($venta['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- PRODUCTOS MAS VENDIDOS -->
    <div class="section-title">Top 10 Productos Más Vendidos</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad Vendida</th>
                <th>Ingresos Generados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos_mas_vendidos as $producto)
            <tr>
                <td>{{ $producto['product_name'] }}</td>
                <td>{{ $producto['total_vendido'] }}</td>
                <td>Q {{ number_format($producto['ingresos'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
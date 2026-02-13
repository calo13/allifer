<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Ventas</title>
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
    </style>
</head>

<body>
    <div class="header">
        <h1>Tienda Virtual - Reporte de Ventas</h1>
        <p>Fecha de reporte: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Método Pago</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->folio }}</td>
                <td>{{ $sale->fecha_venta->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->nombre_cliente }}<br><small>NIT: {{ $sale->nit_cliente }}</small></td>
                <td>{{ ucfirst($sale->tipo_documento) }}</td>
                <td>{{ ucfirst($sale->metodo_pago) }}</td>
                <td>{{ $sale->items->count() }}</td>
                <td>Q {{ number_format($sale->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="font-size: 10px; text-align: right;">
        <strong>Total Ventas: Q {{ number_format($sales->sum('total'), 2) }}</strong>
    </div>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Pedidos Online</title>
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

        .status-badge {
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
            color: white;
            display: inline-block;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Tienda Virtual - Pedidos Online</h1>
        <p>Fecha de reporte: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Orden</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Tipo Entrega</th>
                <th>Método Pago</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->nombre_cliente ?: 'Invitado' }}</td>
                <td>{{ $order->telefono_cliente }}<br>{{ $order->email_cliente }}</td>
                <td>{{ ucfirst($order->tipo_entrega) }}</td>
                <td>{{ ucfirst($order->metodo_pago) }}</td>
                <td>Q {{ number_format($order->total, 2) }}</td>
                <td>{{ ucfirst($order->estado) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="font-size: 10px; text-align: right;">
        <strong>Total en este reporte: Q {{ number_format($orders->sum('total'), 2) }}</strong>
    </div>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $sale->tipo_documento === 'factura' ? 'Factura' : 'Ticket' }} {{ $sale->folio }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            padding: 20px;
            color: #333;
        }

        /* Header compacto con tabla */
        .header {
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4f46e5;
        }

        .header-table {
            width: 100%;
            border: none;
            margin: 0;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .logo {
            width: 40px;
            height: 40px;
        }

        .header-title h1 {
            font-size: 16px;
            margin: 0;
            color: #4f46e5;
        }

        .header-title .slogan {
            font-size: 8px;
            color: #6b7280;
            margin: 0;
        }

        .header-right {
            text-align: right;
            font-size: 8px;
            color: #6b7280;
            line-height: 1.4;
        }

        /* Tipo de documento */
        .documento-tipo {
            text-align: center;
            background: #4f46e5;
            color: white;
            padding: 8px;
            margin: 10px 0;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .documento-tipo .folio {
            font-size: 13px;
            margin-top: 2px;
        }

        /* Info de venta */
        .info-section {
            margin: 10px 0;
            background: #f8fafc;
            padding: 10px 12px;
            border-left: 3px solid #4f46e5;
            font-size: 10px;
        }

        .info-table {
            width: 100%;
            border: none;
            margin: 0;
        }

        .info-table td {
            border: none;
            padding: 3px 0;
            font-size: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
            width: 120px;
        }

        .info-value {
            color: #1f2937;
        }

        /* Tabla de productos */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .products-table th {
            background: #1f2937;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }

        .products-table td {
            padding: 8px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }

        .product-name {
            font-weight: 600;
            color: #1f2937;
        }

        .variant-text {
            font-size: 9px;
            color: #4f46e5;
            margin-top: 2px;
            font-style: italic;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Totales */
        .totals-wrapper {
            width: 100%;
            margin-top: 10px;
        }

        .totals-table {
            width: 220px;
            margin-left: auto;
            border: none;
        }

        .totals-table td {
            border: none;
            padding: 5px 8px;
            font-size: 10px;
        }

        .total-row {
            background: #4f46e5;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .total-row td {
            padding: 8px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .footer .gracias {
            font-size: 12px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .footer p {
            font-size: 8px;
            color: #9ca3af;
            margin: 2px 0;
        }

        .footer .legal {
            margin-top: 8px;
            padding: 6px 12px;
            background: #ecfdf5;
            border: 1px solid #10b981;
            color: #047857;
            font-weight: bold;
            font-size: 9px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <!-- HEADER COMPACTO -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 50px;">
                    @if(file_exists(public_path('images/logo-tienda.png')))
                        <img src="{{ public_path('images/logo-tienda.png') }}" alt="Logo" class="logo">
                    @endif
                </td>
                <td class="header-title">
                    <h1>VendeYa</h1>
                    <p class="slogan">by Procode Innovations</p>
                </td>
                <td class="header-right">
                    NIT: 12345678-9<br>
                    Campo Marte, Zona 5, Guatemala<br>
                    Tel: 4907-5678
                </td>
            </tr>
        </table>
    </div>

    <!-- TIPO DE DOCUMENTO -->
    <div class="documento-tipo">
        {{ $sale->tipo_documento === 'factura' ? 'FACTURA' : 'TICKET DE VENTA' }}
        <div class="folio">No. {{ $sale->folio }}</div>
    </div>

    <!-- INFORMACIÓN DE LA VENTA -->
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Fecha:</td>
                <td class="info-value">{{ $sale->fecha_venta->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td class="info-label">Cliente:</td>
                <td class="info-value">{{ $sale->nombre_cliente }}</td>
            </tr>
            <tr>
                <td class="info-label">NIT:</td>
                <td class="info-value">{{ $sale->nit_cliente }}</td>
            </tr>
            <tr>
                <td class="info-label">Método de Pago:</td>
                <td class="info-value">{{ ucfirst($sale->metodo_pago) }}</td>
            </tr>
            <tr>
                <td class="info-label">Atendido por:</td>
                <td class="info-value">{{ $sale->user->name ?? 'Sistema' }}</td>
            </tr>
        </table>
    </div>

    <!-- PRODUCTOS -->
    <table class="products-table">
        <thead>
            <tr>
                <th style="width: 40px;" class="text-center">Cant.</th>
                <th>Descripción</th>
                <th class="text-right" style="width: 70px;">P. Unit.</th>
                <th class="text-right" style="width: 70px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td>
                        <span class="product-name">{{ $item->product_name }}</span>
                        @if ($item->variant_text)
                            <br><span class="variant-text">{{ $item->variant_text }}</span>
                        @endif
                    </td>
                    <td class="text-right">Q{{ number_format($item->precio_unitario, 2) }}</td>
                    <td class="text-right">Q{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALES -->
    <div class="totals-wrapper">
        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">Q{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>IVA (12%):</td>
                <td class="text-right">Q{{ number_format($sale->iva, 2) }}</td>
            </tr>
            @if ($sale->descuento > 0)
                <tr>
                    <td>Descuento:</td>
                    <td class="text-right" style="color: #dc2626;">-Q{{ number_format($sale->descuento, 2) }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL:</td>
                <td class="text-right">Q{{ number_format($sale->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p class="gracias">¡Gracias por tu compra!</p>
        <p>Este documento es válido como comprobante de venta</p>
        @if ($sale->tipo_documento === 'factura')
            <div class="legal">FACTURA VÁLIDA PARA CRÉDITO FISCAL</div>
        @endif
        <p style="margin-top: 10px;">
            VendeYa by Procode Innovations | www.procodeinnovations.com
        </p>
    </div>

</body>

</html>
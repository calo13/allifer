<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .order-info { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .product-item { border-bottom: 1px solid #e5e7eb; padding: 15px 0; display: flex; justify-content: space-between; }
        .total { background: #eef2ff; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Pedido #{{ $order->order_number }}</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ $order->created_at->format('d/m/Y h:i A') }}</p>
        </div>
        
        <div class="content">
            <div class="order-info">
                <h2 style="margin-top: 0;">Hola {{ $order->nombre_cliente }}</h2>
                <p>Gracias por tu pedido. Aquí están los detalles:</p>
                
                <p><strong>Estado:</strong> {{ $order->status_name }}</p>
                <p><strong>Dirección de entrega:</strong><br>{{ $order->direccion_entrega }}</p>
            </div>
            
            <h3>Productos</h3>
            @foreach($order->items as $item)
            <div class="product-item">
                <div>
                    <strong>{{ $item->product->name }}</strong><br>
                    <span style="color: #6b7280;">Cantidad: {{ $item->quantity }} × Q{{ number_format($item->price, 2) }}</span>
                </div>
                <div style="font-weight: bold;">
                    Q{{ number_format($item->price * $item->quantity, 2) }}
                </div>
            </div>
            @endforeach
            
            <div class="total">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Subtotal:</span>
                    <span>Q{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>IVA:</span>
                    <span>Q{{ number_format($order->iva, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: bold; padding-top: 10px; border-top: 2px solid #6366f1;">
                    <span>Total:</span>
                    <span style="color: #6366f1;">Q{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Si tienes alguna pregunta, contáctanos.<br>Gracias por tu compra!</p>
        </div>
    </div>
</body>
</html>
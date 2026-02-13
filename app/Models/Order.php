<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'order_number',
        'tipo',
        'tipo_entrega',
        'user_id',
        'nombre_cliente',
        'telefono_cliente',
        'email_cliente',
        'direccion_entrega',
        'notas',
        'subtotal',
        'iva',
        'descuento',
        'total',
        'metodo_pago',
        'estado',
        'status_history',
        'aprobado_por',
        'aprobado_at',
        'ip_address',
    ];

    protected $casts = [
        'aprobado_at' => 'datetime',
        'status_history' => 'array',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // ✅ Estados posibles (CORREGIDOS según la BD)
    const STATUS_PENDING = 'pendiente';
    const STATUS_APPROVED = 'aprobado';       // 🆕 CORREGIDO
    const STATUS_PROCESSING = 'en_proceso';
    const STATUS_SHIPPED = 'enviado';         // 🆕 CORREGIDO (antes era 'en_ruta')
    const STATUS_DELIVERED = 'entregado';     // 🆕 CORREGIDO (antes era 'completado')
    const STATUS_CANCELLED = 'cancelado';

    // ========================================
    // MÉTODOS PARA GESTIÓN DE PEDIDOS
    // ========================================

    /**
     * Generar número de pedido único
     * Formato: XX### (ej: JP001, AL002)
     */
    public static function generateOrderNumber($customerName = null)
    {
        // Obtener iniciales del nombre
        $initials = 'GU'; // Default para Guest
        
        if ($customerName) {
            $nameParts = explode(' ', trim($customerName));
            if (count($nameParts) >= 2) {
                $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
            } else {
                $initials = strtoupper(substr($nameParts[0], 0, 2));
            }
        }

        $lastOrder = self::where('order_number', 'LIKE', $initials . '%')
                         ->orderBy('order_number', 'desc')
                         ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, 2));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $orderNumber = $initials . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        while (self::where('order_number', $orderNumber)->exists()) {
            $newNumber++;
            $orderNumber = $initials . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $orderNumber;
    }

    /**
     * Cambiar estado del pedido y registrar en historial
     */
    public function changeStatus($newStatus, $notes = null)
    {
        $oldStatus = $this->estado;
        $this->estado = $newStatus;

        $history = $this->status_history ?? [];
        $history[] = [
            'from' => $oldStatus,
            'to' => $newStatus,
            'notes' => $notes,
            'changed_at' => now()->toDateTimeString(),
            'changed_by' => auth()->user()->name ?? 'Sistema'
        ];

        $this->status_history = $history;
        $this->save();

        return $this;
    }

    /**
     * ✅ Obtener nombre del estado en español (CORREGIDO)
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_APPROVED => 'Aprobado',          // 🆕 AÑADIDO
            self::STATUS_PROCESSING => 'En Proceso',
            self::STATUS_SHIPPED => 'Enviado',            // 🆕 CORREGIDO
            self::STATUS_DELIVERED => 'Entregado',        // 🆕 CORREGIDO
            self::STATUS_CANCELLED => 'Cancelado',
        ];

        return $statuses[$this->estado] ?? 'Desconocido';
    }

    /**
     * ✅ Obtener color del badge según estado (CORREGIDO)
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED => 'success',       // 🆕 AÑADIDO
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SHIPPED => 'primary',        // 🆕 CORREGIDO
            self::STATUS_DELIVERED => 'success',      // 🆕 CORREGIDO
            self::STATUS_CANCELLED => 'danger',
        ];

        return $colors[$this->estado] ?? 'secondary';
    }

    /**
     * ✅ Obtener emoji según estado (CORREGIDO)
     */
    public function getStatusEmojiAttribute()
    {
        $emojis = [
            self::STATUS_PENDING => '🟡',
            self::STATUS_APPROVED => '✅',        // 🆕 AÑADIDO
            self::STATUS_PROCESSING => '🔵',
            self::STATUS_SHIPPED => '🚚',         // 🆕 CORREGIDO
            self::STATUS_DELIVERED => '🟢',       // 🆕 CORREGIDO
            self::STATUS_CANCELLED => '🔴',
        ];

        return $emojis[$this->estado] ?? '⚪';
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('estado', $status);
        }
        return $query;
    }

    /**
     * Scope para búsqueda
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('folio', 'LIKE', "%{$search}%")
                  ->orWhere('nombre_cliente', 'LIKE', "%{$search}%")
                  ->orWhere('email_cliente', 'LIKE', "%{$search}%")
                  ->orWhere('telefono_cliente', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * ✅ Generar enlace de WhatsApp con mensaje (CORREGIDO)
     */
    public function getWhatsappLinkAttribute()
    {
        if (!$this->telefono_cliente) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->telefono_cliente);

        $messages = [
            self::STATUS_APPROVED => "¡Hola {$this->nombre_cliente}! Tu pedido #{$this->order_number} ha sido aprobado. En breve empezamos a prepararlo 📦",
            self::STATUS_PROCESSING => "Hola {$this->nombre_cliente}, tu pedido #{$this->order_number} está siendo preparado. ¡Pronto estará listo! 📦",
            self::STATUS_SHIPPED => "¡Tu pedido #{$this->order_number} está en camino! 🚚 Llegaremos pronto a {$this->direccion_entrega}",
            self::STATUS_DELIVERED => "¡Gracias por tu compra! Pedido #{$this->order_number} entregado. Esperamos verte pronto 😊",
            self::STATUS_CANCELLED => "Tu pedido #{$this->order_number} ha sido cancelado. Si tienes dudas, contáctanos.",
        ];

        $message = $messages[$this->estado] ?? "Actualización de tu pedido #{$this->order_number}";

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }

    /**
     * Generar URL de seguimiento público
     */
    public function getTrackingUrlAttribute()
    {
        return url("/seguimiento/{$this->order_number}");
    }

    // ========================================
    // RELACIONES
    // ========================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function aprobadoPor()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
}
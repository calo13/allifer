<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Order;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public')]
class OrderTracking extends Component
{
    public $orderNumber;
    public $emailOrPhone;
    public $order;

    public function mount($orderNumber = null)
    {
        if ($orderNumber) {
            $this->orderNumber = $orderNumber;
        }
    }

    public function trackOrder()
    {
        $this->validate([
            'orderNumber' => 'required|string',
            'emailOrPhone' => 'nullable|string',
        ]);

        // Buscar por número de orden y (email O teléfono)
        // Se asume que en la tabla orders guardas email y phone en columnas específicas.
        // Ajusta los nombres de columnas según tu esquema real (ej. email, phone, email_cliente, etc.)
        // Buscar por ID, Número de Orden (PED-XXX) o Folio
        $query = Order::where(function ($q) {
            $q->where('order_number', $this->orderNumber)
                ->orWhere('id', $this->orderNumber)
                ->orWhere('folio', $this->orderNumber);
        });

        if ($this->emailOrPhone) {
            $query->where(function ($q) {
                $q->where('email_cliente', $this->emailOrPhone)
                    ->orWhere('telefono_cliente', $this->emailOrPhone);
            });
        }

        $this->order = $query->with(['items.product'])->first();

        if (!$this->order) {
            $this->addError('orderNumber', 'No se encontró un pedido con ese número.');
        }
    }

    public function render()
    {
        return view('livewire.shop.order-tracking');
    }
}

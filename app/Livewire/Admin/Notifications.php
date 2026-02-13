<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        // Obtener pedidos que NO estén Entregados ni Cancelados
        // Se consideran "Activos" y requieren atención
        $activeOrders = Order::whereNotIn('estado', ['entregado', 'cancelado'])
            ->orderBy('created_at', 'desc')
            ->take(10) // Mostrar solo los últimos 10 en la lista
            ->get();

        $count = Order::whereNotIn('estado', ['entregado', 'cancelado'])->count();

        return view('livewire.admin.notifications', [
            'orders' => $activeOrders,
            'count' => $count
        ]);
    }
}

<?php

namespace App\Livewire\Admin\Promotions;

use App\Models\Promotion;
use App\Models\Product;
use Livewire\Component;

class Form extends Component
{
    public $promotion;
    public $name;
    public $description;
    public $type = 'porcentaje';
    public $descuento_porcentaje;
    public $descuento_monto;
    public $active = true;
    public $fecha_inicio;
    public $fecha_fin;
    public $aplica_online = true;
    public $aplica_tienda = true;

    // Selección de productos
    public $selectedProducts = [];
    public $selectAll = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:porcentaje,monto_fijo',
        'descuento_porcentaje' => 'nullable|required_if:type,porcentaje|numeric|min:0|max:100',
        'descuento_monto' => 'nullable|required_if:type,monto_fijo|numeric|min:0',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
    ];

    public function mount($promotion = null)
    {
        if ($promotion) {
            // If Route Model Binding passes a model, use it directly.
            if ($promotion instanceof Promotion) {
                $this->promotion = $promotion;
            } else {
                // Should not happen with binding, but safe fallback
                $this->promotion = Promotion::find($promotion);
            }

            if ($this->promotion) {
                $this->name = $this->promotion->name;
                $this->description = $this->promotion->description;
                $this->type = $this->promotion->type;
                $this->descuento_porcentaje = $this->promotion->descuento_porcentaje;
                $this->descuento_monto = $this->promotion->descuento_monto;
                $this->active = $this->promotion->active;
                $this->fecha_inicio = optional($this->promotion->fecha_inicio)->format('Y-m-d\TH:i');
                $this->fecha_fin = optional($this->promotion->fecha_fin)->format('Y-m-d\TH:i');
                $this->aplica_online = $this->promotion->aplica_online;
                $this->aplica_tienda = $this->promotion->aplica_tienda;

                $this->selectedProducts = $this->promotion->products()->pluck('products.id')->toArray();
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'descuento_porcentaje' => $this->type === 'porcentaje' ? $this->descuento_porcentaje : null,
            'descuento_monto' => $this->type === 'monto_fijo' ? $this->descuento_monto : null,
            'active' => $this->active,
            'fecha_inicio' => $this->fecha_inicio ? $this->fecha_inicio : null,
            'fecha_fin' => $this->fecha_fin ? $this->fecha_fin : null,
            'aplica_online' => $this->aplica_online,
            'aplica_tienda' => $this->aplica_tienda,
        ];

        if ($this->promotion) {
            $this->promotion->update($data);
            $this->promotion->products()->sync($this->selectedProducts);
            session()->flash('message', 'Promoción actualizada con éxito.');
        } else {
            $promotion = Promotion::create($data);
            $promotion->products()->sync($this->selectedProducts);
            session()->flash('message', 'Promoción creada con éxito.');
        }

        return redirect()->route('admin.promotions.index');
    }

    public function render()
    {
        return view('livewire.admin.promotions.form', [
            'products' => Product::where('active', true)->orderBy('name')->get()
        ]);
    }
}

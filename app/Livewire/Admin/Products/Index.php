<?php

namespace App\Livewire\Admin\Products;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->name;

        // Verificar si tiene ventas
        $hasSales = \DB::table('sale_items')->where('product_id', $id)->exists();

        if ($hasSales) {
            // No eliminar, solo desactivar
            $product->active = false;
            $product->save();

            $this->dispatch('product-deactivated', [
                'message' => "El producto '{$productName}' no puede eliminarse porque tiene ventas registradas. Se ha desactivado en su lugar."
            ]);
        } else {
            // Eliminar imagen si existe
            if ($product->image && \Storage::exists('public/' . $product->image)) {
                \Storage::delete('public/' . $product->image);
            }

            $product->delete();

            $this->dispatch('product-deleted', [
                'message' => "El producto '{$productName}' ha sido eliminado correctamente."
            ]);
        }
    }

    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->active = !$product->active;
        $product->save();

        $event = $product->active ? 'product-activated' : 'product-deactivated';
        $message = $product->active
            ? "El producto '{$product->name}' ha sido activado correctamente."
            : "El producto '{$product->name}' ha sido desactivado.";

        $this->dispatch($event, ['message' => $message]);
    }

    public function getProductsQuery()
    {
        return Product::query()
            ->with(['category', 'brand'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhere('barcode', 'like', '%' . $this->search . '%');
            })
            ->latest();
    }

    public function exportExcel()
    {
        $products = $this->getProductsQuery()->get();

        return response()->streamDownload(function () use ($products) {
            // Excel interprets HTML tables correctly.
            // We use a simple HTML structure with inline styles.
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #000000; padding: 5px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                </style>
            </head>
            <body>
                <table>
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Precio Costo</th>
                            <th>Precio Venta</th>
                            <th>Precio Mayorista</th>
                            <th>Stock</th>
                            <th>Stock Mínimo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($products as $product) {
                echo '<tr>
                    <td>' . $product->sku . '</td>
                    <td>' . $product->name . '</td>
                    <td>' . ($product->category->name ?? '') . '</td>
                    <td>' . ($product->brand->name ?? '') . '</td>
                    <td>' . $product->precio_costo . '</td>
                    <td>' . $product->precio_venta . '</td>
                    <td>' . $product->precio_mayorista . '</td>
                    <td>' . $product->stock . '</td>
                    <td>' . $product->stock_minimo . '</td>
                    <td>' . ($product->active ? 'Activo' : 'Inactivo') . '</td>
                </tr>';
            }

            echo '</tbody>
                </table>
            </body>
            </html>';
        }, 'productos-' . date('Y-m-d') . '.xls');
    }

    public function exportPdf()
    {
        $products = $this->getProductsQuery()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.products.pdf', ['products' => $products]);
        $pdf->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'productos-' . date('Y-m-d') . '.pdf');
    }

    public function render()
    {
        $products = $this->getProductsQuery()->paginate($this->perPage);

        return view('livewire.admin.products.index', [
            'products' => $products,
        ]);
    }
}

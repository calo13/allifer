<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\SaleController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Customer;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS - LANDING Y CATÁLOGO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $activePromotions = \App\Models\Promotion::active()->get();
    $discountedProducts = \App\Models\Product::whereHas('promotions', function ($q) {
        $q->active();
    })->inRandomOrder()->take(4)->get();

    return view('welcome', compact('activePromotions', 'discountedProducts'));
})->name('home');

Route::get('/catalogo', function () {
    $products = Product::where('active', true)
        ->where('stock', '>', 0)
        ->with(['category', 'brand', 'images', 'variants'])
        ->latest()
        ->paginate(12);
    $categories = Category::where('active', true)->get();
    return view('catalogo', compact('products', 'categories'));
})->name('catalogo');

Route::get('/carrito', function () {
    return view('shop.cart');
})->name('shop.cart');

Route::get('/producto/{product:slug}', function (Product $product) {
    return view('shop.product', compact('product'));
})->name('shop.product');

Route::get('/pedido-exitoso/{order}', function ($orderId) {
    $order = Order::findOrFail($orderId);
    return view('shop.order-success', compact('order'));
})->name('shop.order-success');

Route::get('/seguimiento/{orderNumber?}', App\Livewire\Shop\OrderTracking::class)->name('shop.order-tracking');

/*
|--------------------------------------------------------------------------
| RUTAS DE CLIENTES (LOGUEADOS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('mi-cuenta')->name('cliente.')->group(function () {

    // Mis pedidos
    Route::get('/pedidos', function () {
        $orders = Order::where('email_cliente', auth()->user()->email)
            ->orWhere('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);
        return view('cliente.pedidos', compact('orders'));
    })->name('pedidos');

    // Detalle de pedido
    Route::get('/pedidos/{order}', function (Order $order) {
        if ($order->email_cliente !== auth()->user()->email && $order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('cliente.pedido-detalle', compact('order'));
    })->name('pedido.detalle');

    // Mi perfil (para clientes)
    Route::get('/perfil', function () {
        return view('cliente.perfil');
    })->name('perfil');

    // Actualizar perfil
    Route::put('/perfil', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    })->name('perfil.update');

    // Cambiar contraseña
    Route::put('/perfil/password', function (Request $request) {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    })->name('perfil.password');
});

/*
|--------------------------------------------------------------------------
| REDIRECCIÓN POST-LOGIN
|--------------------------------------------------------------------------
*/

Route::get('dashboard', function () {
    if (auth()->user()->hasRole('Cliente')) {
        return redirect()->route('catalogo');
    }
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PERFIL PARA TODOS LOS USUARIOS (Admin, Vendedores)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('perfil')->name('perfil.')->group(function () {

    Route::get('/', function () {
        // Si es cliente, redirigir a su perfil de cliente
        if (auth()->user()->hasRole('Cliente')) {
            return redirect()->route('cliente.perfil');
        }
        return view('admin.perfil');
    })->name('index');

    Route::put('/update', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    })->name('update');

    Route::put('/password', function (Request $request) {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    })->name('password');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE CONFIGURACIÓN DE USUARIO (Laravel defaults - opcional)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

/*
|--------------------------------------------------------------------------
| RUTAS DEL PANEL DE ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Administrador,Vendedor,Vendedor Mayorista,Vendedor Online'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ============================================
        // DASHBOARD - Todos los roles admin
        // ============================================
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // ============================================
        // SOLO ADMINISTRADOR
        // ============================================
        Route::middleware(['role:Administrador'])->group(function () {

            // USUARIOS
            Route::get('/users', function () {
                return view('admin.users.index');
            })->name('users.index');

            Route::get('/users/create', function () {
                return view('admin.users.create');
            })->name('users.create');

            Route::get('/users/{user}/edit', function (User $user) {
                return view('admin.users.edit', compact('user'));
            })->name('users.edit');

            // CLIENTES
            Route::get('/customers', function () {
                return view('admin.customers.index');
            })->name('customers.index');

            Route::get('/customers/create', function () {
                return view('admin.customers.create');
            })->name('customers.create');

            Route::get('/customers/{customer}/edit', function (Customer $customer) {
                return view('admin.customers.edit', compact('customer'));
            })->name('customers.edit');

            // CREAR/EDITAR PRODUCTOS
            Route::get('/products/create', function () {
                return view('admin.products.create');
            })->name('products.create');

            Route::get('/products/{product}/edit', function (Product $product) {
                return view('admin.products.edit', compact('product'));
            })->name('products.edit');

            // CATEGORÍAS
            Route::get('/categories', function () {
                return view('admin.categories.index');
            })->name('categories.index');

            // MARCAS
            Route::get('/brands', function () {
                return view('admin.brands.index');
            })->name('brands.index');

            // PROVEEDORES
            Route::get('/suppliers', function () {
                return view('admin.suppliers.index');
            })->name('suppliers.index');

            // REPORTES
            Route::get('/sales/report', function () {
                return view('admin.sales.report');
            })->name('sales.report');

            Route::get('/cash-report', function () {
                return view('admin.cash-report');
            })->name('cash-report');
        });

        // ============================================
        // PRODUCTOS - Ver (Todos los roles admin)
        // ============================================
        Route::get('/products', function () {
            return view('admin.products.index');
        })->name('products.index');

        // ============================================
        // STOCK - Admin, Vendedor, Vendedor Mayorista
        // ============================================
        Route::middleware(['role:Administrador,Vendedor,Vendedor Mayorista'])->group(function () {
            Route::get('/stock-control', function () {
                return view('admin.stock-control.index');
            })->name('stock-control.index');

            Route::get('/stock-control/create', function () {
                return view('admin.stock-control.create');
            })->name('stock-control.create');

            Route::get('/stock-control/product/{productId}/history', function ($productId) {
                return view('admin.stock-control.product-history', compact('productId'));
            })->name('stock-control.product-history');
        });

        // ============================================
        // POS - Admin, Vendedor, Vendedor Mayorista
        // ============================================
        Route::middleware(['role:Administrador,Vendedor,Vendedor Mayorista'])->group(function () {
            Route::get('/pos', function () {
                return view('admin.pos.index');
            })->name('pos.index');

            Route::get('/pos/print/{sale}', [SaleController::class, 'printDocument'])
                ->name('pos.print');
        });

        // ============================================
        // VENTAS - Admin, Vendedor, Vendedor Mayorista, Vendedor Online
        // ============================================
        Route::get('/sales', function () {
            return view('admin.sales.index');
        })->name('sales.index');

        // ============================================
        // PEDIDOS ONLINE - Admin, Vendedor Online
        // ============================================
        Route::middleware(['role:Administrador,Vendedor Online'])->group(function () {
            Route::get('/orders', function () {
                return view('admin.orders.index');
            })->name('orders.index');
        });

        // ============================================
        // PROMOCIONES - Administrador
        // ============================================
        Route::middleware(['role:Administrador'])->group(function () {
            Route::get('/promotions', function () {
                return view('admin.promotions.index');
            })->name('promotions.index');

            Route::get('/promotions/create', function () {
                return view('admin.promotions.create');
            })->name('promotions.create');

            Route::get('/promotions/{promotion}/edit', function (\App\Models\Promotion $promotion) {
                return view('admin.promotions.edit', compact('promotion'));
            })->name('promotions.edit');
        });
    });

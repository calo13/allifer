<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use App\Models\Customer;
use App\Notifications\CustomerInviteNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterTipo = '';
    public $filterActivo = '';

    protected $queryString = ['search', 'filterTipo', 'filterActivo'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleActivo($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->update(['activo' => !$customer->activo]);

        session()->flash('message', $customer->activo ? 'Cliente activado' : 'Cliente desactivado');
    }

    public function inviteUser($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        if (!$customer->email) {
            session()->flash('error', 'El cliente no tiene un email registrado.');
            return;
        }

        // Verificar si ya existe un usuario con ese email
        $existingUser = User::where('email', $customer->email)->first();

        if ($existingUser) {
            // Vincular si no lo está
            if (!$customer->user_id) {
                $customer->user_id = $existingUser->id;
                $customer->save();
                session()->flash('message', 'Cliente vinculado. Enviando correo de activación...');
            }

            // ENVIAR EL CORREO AUNQUE EXISTA (Para reactivar o recordar contraseña)
            try {
                $token = Password::broker()->createToken($existingUser);
                $existingUser->notify(new CustomerInviteNotification($token, $existingUser->email));
                session()->flash('message', 'Se ha enviado un correo de acceso a ' . $existingUser->email);
            } catch (\Exception $e) {
                session()->flash('error', 'Error al enviar el correo: ' . $e->getMessage());
            }
            return;
        }

        try {
            DB::beginTransaction();

            // Crear nuevo usuario
            $newUser = User::create([
                'name' => $customer->nombre,
                'email' => $customer->email,
                'password' => bcrypt(Str::random(16)), // Contraseña temporal
                'active' => true,
            ]);

            // Asignar rol Cliente
            $newUser->assignRole('Cliente');

            // Vincular al cliente
            $customer->user_id = $newUser->id;
            $customer->save();

            // Generar token de restablecimiento de contraseña
            $token = Password::broker()->createToken($newUser);

            // Enviar notificación
            $newUser->notify(new CustomerInviteNotification($token, $newUser->email));

            DB::commit();

            session()->flash('message', 'Invitación enviada correctamente a ' . $customer->email);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al enviar invitación: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('nit', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('telefono', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterTipo, function ($query) {
                $query->where('tipo', $this->filterTipo);
            })
            ->when($this->filterActivo !== '', function ($query) {
                $query->where('activo', $this->filterActivo);
            })
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.customers.index', [
            'customers' => $customers,
        ]);
    }
}

<?php

namespace App\Livewire\Auditorias;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Auditoria;

class AuditoriaList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $auditorias = Auditoria::with('user')
            ->when($this->search, function ($query) {
                $query->where('accion', 'like', '%' . $this->search . '%')
                    ->orWhere('detalle', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.auditorias.auditoria-list', [
            'auditorias' => $auditorias, // ✅ pasamos la variable a la vista
        ])->layout('layouts.app'); // ⚠️ ojo, debeería ser 'layouts.app' y no 'components.layouts.app'
    }

}

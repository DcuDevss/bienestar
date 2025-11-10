<?php

namespace App\Livewire\Auditorias;

use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;

class AuditoriaGeneral extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public string $action = '';
    public string $user_id = '';
    public ?string $desde = null;
    public ?string $hasta = null;
    public int $perPage = 10;

    // resetear paginación cuando cambian filtros
    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function render()
    {
        $s = mb_strtolower(trim($this->search));

        $q = Audit::with(['user','auditable'])
            // 🔎 búsqueda agrupada: action + description (+ entidad Paciente)
            ->when($s !== '', function ($qq) use ($s) {
                $qq->where(function ($w) use ($s) {
                    $w->whereRaw('LOWER(action) LIKE ?', ["%{$s}%"])
                      ->orWhereRaw('LOWER(description) LIKE ?', ["%{$s}%"])
                      // ✅ opcional: buscar por nombre del paciente cuando la entidad sea Paciente
                      ->orWhereHasMorph('auditable', [\App\Models\Paciente::class], function ($m) use ($s) {
                          $m->whereRaw('LOWER(apellido_nombre) LIKE ?', ["%{$s}%"]);
                      });
                });
            })
            // 🎯 filtros exactos
            ->when($this->action !== '', fn($qq) => $qq->where('action', $this->action))
            ->when($this->user_id !== '', fn($qq) => $qq->where('user_id', (int) $this->user_id))
            ->when($this->desde, fn($qq) => $qq->whereDate('created_at', '>=', $this->desde))
            ->when($this->hasta, fn($qq) => $qq->whereDate('created_at', '<=', $this->hasta))
            ->orderByDesc('id');

        $audits = $q->paginate($this->perPage);

        return view('livewire.auditorias.auditoria-general', compact('audits'))
            ->layout('layouts.app');
    }
}

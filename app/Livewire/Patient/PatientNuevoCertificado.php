<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Builder;

class PatientNuevoCertificado extends DataTableComponent
{
    protected $model = Paciente::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setEagerLoadAllRelationsEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
                Column::make("Nombre enfermedad", "disases.pacientes.tipo_enfermedad")
                ->sortable()
                ->searchable(),




            Column::make("Dni", "dni")
                ->sortable()
                ->searchable(),
            Column::make("Direccion", "direccion")
                ->sortable()
                ->searchable(),
            Column::make("Telefono", "telefono")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Genero", "genero")
                ->sortable(),
            Column::make("Edad", "edad")
                ->sortable(),
            Column::make("Fecha nacimiento", "fecha_nacimiento")
                ->sortable(),
            Column::make("Peso", "peso")
                ->sortable(),
            Column::make("Altura", "altura")
                ->sortable(),
            Column::make("Factore id", "factore_id")
                ->sortable(),
            Column::make("Jerarquia id", "jerarquia_id")
                ->sortable(),
            Column::make("Comisaria servicio", "comisaria_servicio")
                ->sortable(),
            Column::make("Fecha atencion", "fecha_atencion")
                ->sortable(),
            Column::make("Enfermedad", "enfermedad")
                ->sortable(),
            Column::make("Remedios", "remedios")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }

    public function builder(): Builder
{
    return Paciente::query()
        ->with(['disases']); // Eager load anything
        //->join('disases') ;// Join some tables
        //->select(); // Select some things
}




}

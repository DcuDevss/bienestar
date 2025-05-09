<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Entrevista;
use App\Models\TipoEntrevista;
use App\Models\ActitudEntrevista;
use App\Models\IndicacionTerapeutica;
use App\Models\Abordaje;
use App\Models\EstadoEntrevista;
use App\Models\GrupoFamiliar;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;

class EditEntrevista extends Component
{
    public $entrevista_id;
    public $tipos_entrevista = [];
    public $actitudes_entrevista = [];
    public $estados_entrevista = [];
    public $indicacionterapeuticas = [];
    public $abordajes = [];
    public $paciente;
    public $paciente_id;
    public $miembros = []; // Para almacenar los miembros de la entrevista
    public $grupo_familiar = [];  // Para almacenar el miembro a editar
    public $editIndex = null;

    // Desacoplar los campos individuales en lugar de usar entrevista_data
    public $tipo_entrevista_id;
    public $actitud_entrevista_id;
    public $estado_entrevista_id;
    public $tecnica_utilizada;
    public $notas_clinicas;
    public $indicacionterapeutica_id;
    public $abordaje_id;
    public $evolucion_tratamiento;
    public $aptitud_reintegro;
    public $posee_arma;
    public $posee_sanciones;
    public $motivo_sanciones;
    public $causas_judiciales;
    public $motivo_causas_judiciales;
    public $sosten_de_familia;
    public $sosten_economico;
    public $tiene_embargos;
    public $enfermedad_preexistente;
    public $medicacion;
    public $realizo_tratamiento_psicologico;
    public $hace_cuanto_tratamiento_psicologico;
    public $signos_y_sintomas;
    public $fecha;
    public $profesional;
    public $duracion;
    public $motivo;
    public $medicacion_recetada;
    public $fuma;
    public $cantidad_fuma;
    public $consume_alcohol;
    public $frecuencia_alcohol;
    public $consume_sustancias;
    public $tipo_sustancia;
    public $realiza_actividades;
    public $actividades;
    public $horas_suficientes;
    public $horas_dormir;


    public function mount($entrevista_id)
    {
        $this->entrevista_id = $entrevista_id;



        // Buscar la entrevista por ID
        $entrevista = Entrevista::find($this->entrevista_id);
        if (!$entrevista) {
            session()->flash('error', 'La entrevista no se encontró.');
            return redirect()->route('entrevistas.index');
        }

        // Asignar los valores de la entrevista a las propiedades individuales
        $this->tipo_entrevista_id = $entrevista->tipo_entrevista_id;
        $this->actitud_entrevista_id = $entrevista->actitud_entrevista_id;
        $this->estado_entrevista_id = $entrevista->estado_entrevista_id;
        $this->tecnica_utilizada = $entrevista->tecnica_utilizada;
        $this->notas_clinicas = $entrevista->notas_clinicas;
        $this->indicacionterapeutica_id = $entrevista->indicacionterapeutica_id;
        $this->abordaje_id = $entrevista->abordaje_id;
        $this->evolucion_tratamiento = $entrevista->evolucion_tratamiento;
        $this->aptitud_reintegro = $entrevista->aptitud_reintegro;
        $this->posee_arma = $entrevista->posee_arma;
        $this->posee_sanciones = $entrevista->posee_sanciones;
        $this->motivo_sanciones = $entrevista->motivo_sanciones;
        $this->causas_judiciales = $entrevista->causas_judiciales;
        $this->motivo_causas_judiciales = $entrevista->motivo_causas_judiciales;
        $this->sosten_de_familia = $entrevista->sosten_de_familia;
        $this->sosten_economico = $entrevista->sosten_economico;
        $this->tiene_embargos = $entrevista->tiene_embargos;
        $this->enfermedad_preexistente = $entrevista->enfermedad_preexistente;
        $this->medicacion = $entrevista->medicacion;
        $this->realizo_tratamiento_psicologico = $entrevista->realizo_tratamiento_psicologico;
        $this->hace_cuanto_tratamiento_psicologico = $entrevista->hace_cuanto_tratamiento_psicologico;
        $this->signos_y_sintomas = $entrevista->signos_y_sintomas;
        $this->fecha = $entrevista->fecha;
        $this->profesional = $entrevista->profesional;
        $this->duracion = $entrevista->duracion;
        $this->motivo = $entrevista->motivo;
        $this->medicacion_recetada = $entrevista->medicacion_recetada;
        $this->fuma = $entrevista->fuma;
        $this->cantidad_fuma = $entrevista->cantidad_fuma;
        $this->consume_alcohol = $entrevista->consume_alcohol;
        $this->frecuencia_alcohol = $entrevista->frecuencia_alcohol;
        $this->consume_sustancias = $entrevista->consume_sustancias;
        $this->tipo_sustancia = $entrevista->tipo_sustancia;
        $this->realiza_actividades = $entrevista->realiza_actividades;
        $this->actividades = $entrevista->actividades;
        $this->horas_suficientes = $entrevista->horas_suficientes;
        $this->horas_dormir = $entrevista->horas_dormir;
        $this->miembros = $entrevista->grupoFamiliar;


        if (is_null($this->miembros)) {
        $this->miembros = [];
        }

        // Cargar opciones para los campos relacionados (tipos de entrevista, actitudes, estados)
        $this->tipos_entrevista = TipoEntrevista::all();
        $this->actitudes_entrevista = ActitudEntrevista::all();
        $this->estados_entrevista = EstadoEntrevista::all();
        $this->indicacionterapeuticas = IndicacionTerapeutica::all();
        $this->abordajes = Abordaje::all();
    }

    public function editMember($id)
    {
        $this->editIndex = $id;
        $miembro = GrupoFamiliar::find($id);

        if ($miembro) {
            // Asignar el miembro seleccionado a $grupo_familiar
            $this->grupo_familiar = $miembro->toArray();  // Actualiza $grupo_familiar con los datos del miembro
        }
    }

    // Método para guardar los cambios en el miembro editado
    public function saveMember()
    {
        // Validar los datos
        $this->validate([
            'grupo_familiar.nombre' => 'required|string',
            'grupo_familiar.edad' => 'required|numeric',
            'grupo_familiar.ocupacion' => 'nullable|string',
            'grupo_familiar.parentesco' => 'nullable|string',
            'grupo_familiar.antecedentes_psiquiatricos' => 'nullable|string',
        ]);

        if ($this->editIndex !== null) {
            // Buscar el miembro a actualizar
            $miembro = GrupoFamiliar::find($this->editIndex);

            if ($miembro) {
                // Actualizar los campos del miembro con los nuevos valores
                $miembro->update([
                    'nombre' => $this->grupo_familiar['nombre'],
                    'edad' => $this->grupo_familiar['edad'],
                    'ocupacion' => $this->grupo_familiar['ocupacion'],
                    'parentesco' => $this->grupo_familiar['parentesco'],
                    'antecedentes_psiquiatricos' => $this->grupo_familiar['antecedentes_psiquiatricos'],
                ]);

                // Recargar la lista de miembros
                $entrevista = Entrevista::find($this->entrevista_id);
                $this->miembros = $entrevista->grupoFamiliar;  // Recargar los miembros para reflejar los cambios

                // Mostrar mensaje de éxito
                session()->flash('message', 'Miembro editado exitosamente.');

                // Limpiar el estado de edición
                $this->editIndex = null;
                $this->grupo_familiar = [];
            }
        }
    }


    // Método para actualizar los datos de la entrevista
    public function update()
    {
        // Validar los datos antes de actualizar
        $this->validate([
            'tipo_entrevista_id' => 'required|integer',
            'actitud_entrevista_id' => 'required|integer',
            'estado_entrevista_id' => 'nullable|integer',
            'tecnica_utilizada' => 'nullable|string|max:1000',
            'notas_clinicas' => 'nullable|string|max:1000',
            'indicacionterapeutica_id' => 'nullable|integer',
            'abordaje_id' => 'nullable|integer',
            'evolucion_tratamiento' => 'nullable|string|max:500',
            'aptitud_reintegro' => 'nullable|integer',
            'posee_arma' => 'nullable|boolean',
            'posee_sanciones' => 'nullable|boolean',
            'motivo_sanciones' => 'nullable|string|max:500',
            'causas_judiciales' => 'nullable|boolean',
            'motivo_causas_judiciales' => 'nullable|string|max:500',
            'sosten_de_familia' => 'nullable|boolean',
            'sosten_economico' => 'nullable|boolean',
            'tiene_embargos' => 'nullable|boolean',
            'enfermedad_preexistente' => 'nullable|boolean',
            'medicacion' => 'nullable|string|max:500',
            'realizo_tratamiento_psicologico' => 'nullable|boolean',
            'hace_cuanto_tratamiento_psicologico' => 'nullable|string|max:255',
            'signos_y_sintomas' => 'nullable|string|max:1000',
            'fecha' => 'nullable|date',
            'profesional' => 'nullable|string|max:255',
            'duracion' => 'nullable|string|max:255',
            'motivo' => 'nullable|string|max:255',
            'medicacion_recetada' => 'nullable|string|max:500',
            'fuma' => 'nullable|boolean',
            'cantidad_fuma' => 'nullable|integer',
            'consume_alcohol' => 'nullable|boolean',
            'frecuencia_alcohol' => 'nullable|string|max:255',
            'consume_sustancias' => 'nullable|boolean',
            'tipo_sustancia' => 'nullable|string|max:255',
            'realiza_actividades' => 'nullable|boolean',
            'actividades' => 'nullable|string|max:1000',
            'horas_suficientes' => 'nullable|boolean',
            'horas_dormir' => 'nullable|integer|between:0,24',
        ]);

        $entrevista = Entrevista::find($this->entrevista_id);
        if ($entrevista) {
            // Actualizar los datos de la entrevista
            $entrevista->tipo_entrevista_id = $this->tipo_entrevista_id;
            $entrevista->actitud_entrevista_id = $this->actitud_entrevista_id;
            $entrevista->estado_entrevista_id = $this->estado_entrevista_id;
            $entrevista->tecnica_utilizada = $this->tecnica_utilizada;
            $entrevista->notas_clinicas = $this->notas_clinicas;
            $entrevista->indicacionterapeutica_id = $this->indicacionterapeutica_id;
            $entrevista->abordaje_id = $this->abordaje_id;
            $entrevista->evolucion_tratamiento = $this->evolucion_tratamiento;
            $entrevista->aptitud_reintegro = $this->aptitud_reintegro;
            $entrevista->posee_arma = $this->posee_arma;
            $entrevista->posee_sanciones = $this->posee_sanciones;
            $entrevista->motivo_sanciones = $this->motivo_sanciones;
            $entrevista->causas_judiciales = $this->causas_judiciales;
            $entrevista->motivo_causas_judiciales = $this->motivo_causas_judiciales;
            $entrevista->sosten_de_familia = $this->sosten_de_familia;
            $entrevista->sosten_economico = $this->sosten_economico;
            $entrevista->tiene_embargos = $this->tiene_embargos;
            $entrevista->enfermedad_preexistente = $this->enfermedad_preexistente;
            $entrevista->medicacion = $this->medicacion;
            $entrevista->realizo_tratamiento_psicologico = $this->realizo_tratamiento_psicologico;
            $entrevista->hace_cuanto_tratamiento_psicologico = $this->hace_cuanto_tratamiento_psicologico;
            $entrevista->signos_y_sintomas = $this->signos_y_sintomas;
            $entrevista->fecha = $this->fecha;
            $entrevista->profesional = $this->profesional;
            $entrevista->duracion = $this->duracion;
            $entrevista->motivo = $this->motivo;
            $entrevista->medicacion_recetada = $this->medicacion_recetada;
            $entrevista->fuma = $this->fuma;
            $entrevista->cantidad_fuma = $this->cantidad_fuma;
            $entrevista->consume_alcohol = $this->consume_alcohol;
            $entrevista->frecuencia_alcohol = $this->frecuencia_alcohol;
            $entrevista->consume_sustancias = $this->consume_sustancias;
            $entrevista->tipo_sustancia = $this->tipo_sustancia;
            $entrevista->realiza_actividades = $this->realiza_actividades;
            $entrevista->actividades = $this->actividades;
            $entrevista->horas_suficientes = $this->horas_suficientes;
            $entrevista->horas_dormir = $this->horas_dormir;

            // Guardar los cambios
            $entrevista->save();

            // Mostrar mensaje de éxito
            session()->flash('success', 'La entrevista ha sido actualizada correctamente.');
        }
    }

    public function render()
    {
        return view('livewire.doctor.edit-entrevista')->layout('layouts.app');
    }
}

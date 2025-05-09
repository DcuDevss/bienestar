<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\TipoEntrevista;
use App\Models\ActitudEntrevista;
use App\Models\IndicacionTerapeutica;
use App\Models\Abordaje;
use App\Models\EstadoEntrevista;
use App\Models\Entrevista;
use App\Models\GrupoFamiliar;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;


class EntrevistaFormController extends Component
{
    // Propiedades del formulario
    public $tipo_entrevista_id;
    public $posee_arma = '';
    public $posee_sanciones = '';
    public $motivo_sanciones;
    public $causas_judiciales = '';
    public $motivo_causas_judiciales;
    public $sosten_de_familia = '';
    public $sosten_economico = '';
    public $tiene_embargos = '';
    public $enfermedad_preexistente = '';
    public $medicacion;
    public $realizo_tratamiento_psicologico = '';
    public $hace_cuanto_tratamiento_psicologico;
    public $signos_y_sintomas;
    public $fecha;
    public $profesional;
    public $duracion;
    public $motivo;
    public $medicacion_recetada;
    public $fuma = '';
    public $cantidad_fuma;
    public $consume_alcohol = '';
    public $frecuencia_alcohol;
    public $consume_sustancias = '';
    public $tipo_sustancia;
    public $realiza_actividades = '';
    public $actividades;
    public $horas_dormir;
    public $horas_suficientes = '';
    public $actitud_entrevista_id;
    public $notas_clinicas;
    public $tecnica_utilizada;
    public $indicacionterapeutica_id;
    public $abordaje_id;
    public $derivacion_psiquiatrica;
    public $evolucion_tratamiento;
    public $aptitud_reintegro;
    public $estado_entrevista_id;
    public $paciente_id;
    public $paciente;
    public $user_id;
    public $entrevista;
    public $entrevista_id;

    public $tipos_entrevista;
    public $actitudes_entrevista;
    public $indicacionterapeuticas;
    public $abordajes;
    public $estados_entrevista;
    public $index;


    public function mount($paciente_id)
    {

        $this->paciente_id = $paciente_id;
        $this->paciente = Paciente::find($paciente_id);
        // Cargar las opciones de los select

        $this->tipos_entrevista = TipoEntrevista::all();  // Simula la carga de los tipos
        $this->actitudes_entrevista = ActitudEntrevista::all();
        $this->indicacionterapeuticas = IndicacionTerapeutica::all();
        $this->abordajes = Abordaje::all();
        $this->estados_entrevista = EstadoEntrevista::all();



        // Valor predeterminado
    }

    public $grupo_familiar = [
        'nombre' => '',
        'edad' => '',
        'ocupacion' => '',
        'parentesco' => '',
        'antecedentes_psiquiatricos' => '',
    ];

    public $miembros = [];

    public function addMember()
    {

        $entrevista = Entrevista::find($this->entrevista_id);
        $this->validate([
            'grupo_familiar.nombre' => 'nullable|string',
            'grupo_familiar.edad' => 'nullable|numeric',
            'grupo_familiar.ocupacion' => 'nullable|string',
            'grupo_familiar.parentesco' => 'nullable|string',
            'grupo_familiar.antecedentes_psiquiatricos' => 'nullable|string',
        ]);

        // Agregar el miembro al array $miembros
        $this->miembros[] = $this->grupo_familiar;
        

        // Limpiar los campos después de agregar el miembro
        $this->grupo_familiar = [
            'nombre' => '',
            'edad' => '',
            'ocupacion' => '',
            'parentesco' => '',
            'antecedentes_psiquiatricos' => '',
        ];

        // Mensaje de éxito
        session()->flash('message', 'Miembro agregado exitosamente.');
    }



    public function removeMember($index)
    {
        // Eliminar el miembro del array $miembros utilizando el índice
        array_splice($this->miembros, $index, 1);

        // Mensaje de éxito
        session()->flash('message', 'Miembro eliminado exitosamente.');
    }

    public function submit()
    {
        try {
            if (!$this->paciente_id) {
                session()->flash('error', 'No se ha especificado un paciente.');
                return;
            }

            $this->posee_arma = ($this->posee_arma === '') ? null : (int) $this->posee_arma;
            $this->posee_sanciones = ($this->posee_sanciones === '') ? null : (int) $this->posee_sanciones;
            $this->motivo_sanciones = $this->motivo_sanciones ?? '';
            $this->causas_judiciales = $this->causas_judiciales ?? 0;
            $this->motivo_causas_judiciales = $this->motivo_causas_judiciales ?? '';
            $this->sosten_de_familia = $this->sosten_de_familia ?? 0;
            $this->sosten_economico = $this->sosten_economico ?? 0;
            $this->tiene_embargos = $this->tiene_embargos ?? 0;
            $this->enfermedad_preexistente = $this->enfermedad_preexistente ?? 0;
            $this->medicacion = $this->medicacion ?? '';
            $this->realizo_tratamiento_psicologico = $this->realizo_tratamiento_psicologico ?? 0;
            $this->hace_cuanto_tratamiento_psicologico = $this->hace_cuanto_tratamiento_psicologico ?? '';
            $this->signos_y_sintomas = $this->signos_y_sintomas ?? '';
            $this->fecha = $this->fecha ?? now();
            $this->profesional = $this->profesional ?? '';
            $this->duracion = $this->duracion ?? '';
            $this->motivo = $this->motivo ?? '';
            $this->medicacion_recetada = $this->medicacion_recetada ?? '';
            $this->fuma = $this->fuma ?? 0;
            $this->cantidad_fuma = $this->cantidad_fuma ?? 0;
            $this->consume_alcohol = $this->consume_alcohol ?? 0;
            $this->frecuencia_alcohol = $this->frecuencia_alcohol ?? '';
            $this->consume_sustancias = $this->consume_sustancias ?? 0;
            $this->tipo_sustancia = $this->tipo_sustancia ?? '';
            $this->realiza_actividades = $this->realiza_actividades ?? 0;
            $this->actividades = $this->actividades ?? '';
            $this->horas_dormir = $this->horas_dormir ?? 0;
            $this->horas_suficientes = $this->horas_suficientes ?? 0;
            $this->actitud_entrevista_id = $this->actitud_entrevista_id ?? 0;
            $this->notas_clinicas = $this->notas_clinicas ?? '';
            $this->tecnica_utilizada = $this->tecnica_utilizada ?? 0;
            $this->indicacionterapeutica_id = $this->indicacionterapeutica_id ?? null;
            $this->abordaje_id = $this->abordaje_id ?? null;
            $this->derivacion_psiquiatrica = $this->derivacion_psiquiatrica ?? null;
            $this->evolucion_tratamiento = $this->evolucion_tratamiento ?? '';
            $this->aptitud_reintegro = $this->aptitud_reintegro ?? 0;
            $this->estado_entrevista_id = $this->estado_entrevista_id ?? null;



            $this->validate([
                'tipo_entrevista_id' => 'nullable|integer',
                'actitud_entrevista_id' => 'nullable|integer',
                'estado_entrevista_id' => 'nullable|integer', // Solo para Postulante o Reintegro
                'tecnica_utilizada' => 'nullable|string|max:1000',
                'grupo_familiar' => 'nullable|array', // Validación del array de miembros
                'notas_clinicas' => 'nullable|string|max:1000', // Validación de notas clínicas
                'indicacionterapeutica_id' => 'nullable|integer', // Solo para Tratamiento o Seguimiento
                'abordaje_id' => 'nullable|integer',
                'evolucion_tratamiento' => 'nullable|string|max:500', // Validación de evolución del tratamiento
                'aptitud_reintegro' => 'nullable|integer', // Solo para Reintegro

                // Campos del grupo familiar
                'miembros.*.nombre' => 'nullable|string|max:255', // Nombre del miembro, obligatorio
                'miembros.*.edad' => 'nullable|integer|min:1|max:120', // Edad del miembro, obligatorio
                'miembros.*.ocupacion' => 'nullable|string|max:255', // Ocupación del miembro, obligatorio
                'miembros.*.parentesco' => 'nullable|string|max:255', // Parentesco del miembro (opcional)
                'miembros.*.antecedentes_psiquiatricos' => 'nullable|string|max:500', // Antecedentes psiquiátricos del miembro (opcional)

                // Validaciones para campos adicionales si es necesario
                'posee_arma' => 'nullable|in:0,1', // Posee arma (sí/no)
                'posee_sanciones' => 'nullable|in:0,1', // Posee sanciones (sí/no)
                'motivo_sanciones' => 'nullable|string|max:500', // Motivo de las sanciones
                'causas_judiciales' => 'nullable|boolean', // Tiene causas judiciales (sí/no)
                'motivo_causas_judiciales' => 'nullable|string|max:500', // Motivo de las causas judiciales
                'sosten_de_familia' => 'nullable|boolean', // Sosten de familia
                'sosten_economico' => 'nullable|boolean', // Sosten económico
                'tiene_embargos' => 'nullable|boolean', // Sosten económico
                'enfermedad_preexistente' => 'nullable|boolean', // Enfermedad preexistente
                'medicacion' => 'nullable|string|max:500', // Medicación
                'realizo_tratamiento_psicologico' => 'nullable|boolean', // Realizó tratamiento psicológico
                'hace_cuanto_tratamiento_psicologico' => 'nullable|string|max:255', // Hace cuánto tratamiento psicológico
                'signos_y_sintomas' => 'nullable|string|max:1000', // Signos y síntomas
                'fecha' => 'nullable|date', // Fecha
                'profesional' => 'nullable|string|max:255', // Profesional
                'duracion' => 'nullable|string|max:255', // Duración
                'motivo' => 'nullable|string|max:255', // Motivo
                'medicacion_recetada' => 'nullable|string|max:500', // Medicación recetada
                'fuma' => 'nullable|boolean', // Fuma (sí/no)
                'cantidad_fuma' => 'nullable|string|max:255', // Cantidad de cigarrillos si fuma
                'consume_alcohol' => 'nullable|boolean', // Consume alcohol (sí/no)
                'frecuencia_alcohol' => 'nullable|string|max:255', // Frecuencia de consumo de alcohol
                'consume_sustancias' => 'nullable|boolean', // Consume sustancias (sí/no)
                'tipo_sustancia' => 'nullable|string|max:255', // Tipo de sustancia
                'realiza_actividades' => 'nullable|boolean', // Realiza actividades (sí/no)
                'actividades' => 'nullable|string|max:1000', // Descripción de actividades
                'horas_suficientes' => 'nullable|boolean', // Horas suficientes de sueño (sí/no)
                'horas_dormir' => 'nullable|integer|between:0,24', // Horas de sueño

            ]);


            // Guardar la entrevista
            $entrevista = new Entrevista();
            $entrevista->tipo_entrevista_id = $this->tipo_entrevista_id ?? null;
            $entrevista->posee_arma = $this->posee_arma ?? null;
            $entrevista->posee_sanciones = $this->posee_sanciones ?? null;
            $entrevista->motivo_sanciones = $this->motivo_sanciones ?? null;
            $entrevista->causas_judiciales = $this->causas_judiciales ?? null;
            $entrevista->motivo_causas_judiciales = $this->motivo_causas_judiciales ?? null;
            $entrevista->sosten_de_familia = $this->sosten_de_familia ?? null;
            $entrevista->sosten_economico = $this->sosten_economico ?? null;
            $entrevista->tiene_embargos = $this->tiene_embargos ?? null;
            $entrevista->enfermedad_preexistente = $this->enfermedad_preexistente ?? null;
            $entrevista->medicacion = $this->medicacion ?? null;
            $entrevista->realizo_tratamiento_psicologico = $this->realizo_tratamiento_psicologico ?? null;
            $entrevista->hace_cuanto_tratamiento_psicologico = $this->hace_cuanto_tratamiento_psicologico ?? null;
            $entrevista->signos_y_sintomas = $this->signos_y_sintomas ?? null;
            $entrevista->fecha = $this->fecha ?? null;
            $entrevista->profesional = $this->profesional ?? null;
            $entrevista->duracion = $this->duracion ?? null;
            $entrevista->motivo = $this->motivo ?? null;
            $entrevista->medicacion_recetada = $this->medicacion_recetada ?? null;
            $entrevista->fuma = $this->fuma ?? null;
            $entrevista->cantidad_fuma = $this->cantidad_fuma ?? null;
            $entrevista->consume_alcohol = $this->consume_alcohol ?? null;
            $entrevista->frecuencia_alcohol = $this->frecuencia_alcohol ?? null;
            $entrevista->consume_sustancias = $this->consume_sustancias ?? null;
            $entrevista->tipo_sustancia = $this->tipo_sustancia ?? null;
            $entrevista->realiza_actividades = $this->realiza_actividades ?? null;
            $entrevista->actividades = $this->actividades ?? null;
            $entrevista->horas_dormir = $this->horas_dormir ?? null;
            $entrevista->horas_suficientes = $this->horas_suficientes ?? null;
            $entrevista->actitud_entrevista_id = $this->actitud_entrevista_id ?? null;
            $entrevista->notas_clinicas = $this->notas_clinicas ?? null;
            $entrevista->tecnica_utilizada = $this->tecnica_utilizada ?? null;
            $entrevista->indicacionterapeutica_id = $this->indicacionterapeutica_id ?? null;
            $entrevista->abordaje_id = $this->abordaje_id ?? null;
            $entrevista->derivacion_psiquiatrica = $this->derivacion_psiquiatrica ?? null;
            $entrevista->evolucion_tratamiento = $this->evolucion_tratamiento ?? null;
            $entrevista->aptitud_reintegro = $this->aptitud_reintegro ?? null;
            $entrevista->estado_entrevista_id = $this->estado_entrevista_id ?? null;
            $entrevista->user_id = auth()->id();

            $entrevista->paciente_id = $this->paciente_id;

            $entrevista->save();

            $entrevista_id = $entrevista->id;

            // Guardar los miembros asociados con la entrevista
            foreach ($this->miembros as $miembro) {
                GrupoFamiliar::create([
                    'entrevista_id' => $entrevista_id, // Asociar el miembro con la entrevista
                    'nombre' => $miembro['nombre'],
                    'edad' => $miembro['edad'],
                    'ocupacion' => $miembro['ocupacion'],
                    'parentesco' => $miembro['parentesco'] ?? null,
                    'antecedentes_psiquiatricos' => $miembro['antecedentes_psiquiatricos'] ?? null,
                ]);
            }


            $this->reset([
                'tipo_entrevista_id',
                'posee_arma',
                'posee_sanciones',
                'motivo_sanciones',
                'causas_judiciales',
                'motivo_causas_judiciales',
                'sosten_de_familia',
                'sosten_economico',
                'tiene_embargos',
                'enfermedad_preexistente',
                'medicacion',
                'realizo_tratamiento_psicologico',
                'hace_cuanto_tratamiento_psicologico',
                'signos_y_sintomas',
                'fecha',
                'profesional',
                'duracion',
                'motivo',
                'medicacion_recetada',
                'fuma',
                'cantidad_fuma',
                'consume_alcohol',
                'frecuencia_alcohol',
                'consume_sustancias',
                'tipo_sustancia',
                'realiza_actividades',
                'actividades',
                'horas_dormir',
                'horas_suficientes',
                'actitud_entrevista_id',
                'notas_clinicas',
                'tecnica_utilizada',
                'indicacionterapeutica_id',
                'abordaje_id',
                'derivacion_psiquiatrica',
                'evolucion_tratamiento',
                'aptitud_reintegro',
                'estado_entrevista_id',
                'paciente_id',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar la entrevista: ' . $e->getMessage());
            session()->flash('error', 'Error al guardar la entrevista.');
        }


        session()->flash('message', 'Entrevista registrada con éxito.');
    }

    public function render()
    {
        return view('livewire.doctor.entrevista-form')->layout('layouts.app');
    }
}

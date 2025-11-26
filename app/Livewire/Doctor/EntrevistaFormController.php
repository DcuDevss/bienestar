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
use App\Models\Portacion;
use App\Models\SaludMentale;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;


class EntrevistaFormController extends Component
{
    // Propiedades del formulario
    public $tipo_entrevista_id = '';
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
    public $actitud_entrevista_id = '';
    public $notas_clinicas;
    public $tecnica_utilizada;
    public $indicacionterapeutica_id;
    public $abordaje_id = '';
    public $derivacion_psiquiatrica;
    public $evolucion_tratamiento;
    public $aptitud_reintegro = '';
    public $estado_entrevista_id = '';
    public $paciente_id;
    public $paciente;
    public $user_id;
    public $entrevista;
    public $entrevista_id;
    public $portacion_id = '';
    public $recomendacion = '';
    public $salud_mentale_id = '';
    public $salud_mentales = [];

    // 🔹 NUEVOS CAMPOS
    public $posee_vivienda_propia;
    public $tiempo_en_ultimo_destino;
    public $destino_anterior;
    public $fecha_ultimo_ascenso;
    public $horario_laboral;
    public $hace_adicionales;
    public $anios_residencia_isla;

    public $posee_oficio_profesion;
    public $situacion_laboral;
    public $relacion_companieros_superiores;
    public $situacion_familiar;
    public $ultimos_6_meses;
    public $ultimos_dias_semanas;
    public $pesadillas_trabajo;

    public $tipos_entrevista;
    public $actitudes_entrevista;
    public $indicacionterapeuticas;
    public $abordajes;
    public $estados_entrevista;
    public $portacions;
    public $index;



    public function mount($paciente_id)
    {

        $this->paciente_id = $paciente_id;
        $this->paciente = Paciente::find($paciente_id);
        // Cargaar las opciones de los select
        $this->tipos_entrevista = TipoEntrevista::all();  // Simula la caarga de los tipos
        $this->actitudes_entrevista = ActitudEntrevista::all();
        $this->indicacionterapeuticas = IndicacionTerapeutica::all();
        $this->abordajes = Abordaje::all();
        $this->estados_entrevista = EstadoEntrevista::all();
        $this->portacions = Portacion::all();
        // $this->salud_mentales = SaludMentale::all();
        // $this->salud_mentales = SaludMentale::orderBy('codigo', 'asc')->get();
        $this->salud_mentales = SaludMentale::select('id','codigo','name','slug')->get()
            ->sortBy(function ($s) {
                return preg_match('/^\d+$/', (string) $s->codigo)
                    ? str_pad($s->codigo, 10, '0', STR_PAD_LEFT) // numéricos con padding
                    : (string) $s->codigo;                       // no numéricos tal cual
            })
            ->values(); // reindexa colección

        Log::info('Registros en $salud_mentales: '.$this->salud_mentales->count());
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
        $this->dispatch(
            'swal',
            title: 'Agregado',
            text:  'Miembro agregado exitosamente.',
            icon:  'success'
        );
    }



    public function removeMember($index)
    {
        // Eliminar el miembro del array $miembros utilizando el índice
        array_splice($this->miembros, $index, 1);

        // Mensaje de éxito
        $this->dispatch(
            'swal',
            title: 'Eliminado',
            text:  'Miembro eliminado exitosamente.',
            icon:  'success'
        );
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
            $this->motivo_sanciones = $this->motivo_sanciones ?? null;
            $this->causas_judiciales = ($this->causas_judiciales === '') ? null : (int) $this->causas_judiciales;
            $this->motivo_causas_judiciales = $this->motivo_causas_judiciales ?? null;
            $this->sosten_de_familia = ($this->sosten_de_familia === '') ? null : (int) $this->sosten_de_familia;
            $this->sosten_economico = ($this->sosten_economico === '') ? null : (int) $this->sosten_economico;
            $this->tiene_embargos = ($this->tiene_embargos === '') ? null : (int) $this->tiene_embargos;
            $this->enfermedad_preexistente = ($this->enfermedad_preexistente === '') ? null : (int) $this->enfermedad_preexistente;
            $this->medicacion = $this->medicacion ?? null;
            $this->realizo_tratamiento_psicologico = ($this->realizo_tratamiento_psicologico === '') ? null : (int) $this->realizo_tratamiento_psicologico;
            $this->hace_cuanto_tratamiento_psicologico = $this->hace_cuanto_tratamiento_psicologico ?? null;
            $this->signos_y_sintomas = $this->signos_y_sintomas ?? null;
            $this->fecha = $this->fecha ?: null;
            $this->profesional = $this->profesional ?? null;
            $this->duracion = $this->duracion ?? null;
            $this->motivo = $this->motivo ?? null;
            $this->medicacion_recetada = $this->medicacion_recetada ?? null;
            $this->fuma = ($this->fuma === '') ? null : (int) $this->fuma;
            $this->cantidad_fuma = $this->cantidad_fuma ?? null;
            $this->consume_alcohol = ($this->consume_alcohol === '') ? null : (int) $this->consume_alcohol;
            $this->frecuencia_alcohol = $this->frecuencia_alcohol ?? null;
            $this->consume_sustancias = ($this->consume_sustancias === '') ? null : (int) $this->consume_sustancias;
            $this->tipo_sustancia = $this->tipo_sustancia ?? null;
            $this->realiza_actividades = ($this->realiza_actividades === '') ? null : (int) $this->realiza_actividades;
            $this->actividades = $this->actividades ?? null;
            $this->horas_dormir = $this->horas_dormir ?? null;
            $this->horas_suficientes = ($this->horas_suficientes === '') ? null : (int) $this->horas_suficientes;
            $this->actitud_entrevista_id = ($this->actitud_entrevista_id === '' || $this->actitud_entrevista_id === null) ? null: (int) $this->actitud_entrevista_id;
            $this->notas_clinicas = $this->notas_clinicas ?? null;
            $this->tecnica_utilizada = $this->tecnica_utilizada ?? null;
            $this->indicacionterapeutica_id = ($this->indicacionterapeutica_id === '' || $this->indicacionterapeutica_id === null) ? null : (int) $this->indicacionterapeutica_id;
            $this->abordaje_id = ($this->abordaje_id === '' || $this->abordaje_id === null) ? null : (int) $this->abordaje_id;
            $this->derivacion_psiquiatrica = $this->derivacion_psiquiatrica ?? null;
            $this->evolucion_tratamiento = $this->evolucion_tratamiento ?? null;
            $this->aptitud_reintegro = ($this->aptitud_reintegro === '' || $this->aptitud_reintegro === null) ? null : (int) $this->aptitud_reintegro;
            $this->estado_entrevista_id = ($this->estado_entrevista_id === '' || $this->estado_entrevista_id === null) ? null : (int) $this->estado_entrevista_id;
            $this->portacion_id = ($this->portacion_id === '' || $this->portacion_id === null) ? null : (int) $this->portacion_id;
            $this->recomendacion = ($this->recomendacion === '') ? null : (int) $this->recomendacion;
            $this->salud_mentale_id = ($this->salud_mentale_id === '' || $this->salud_mentale_id === null) ? null : (int) $this->salud_mentale_id;

            $this->posee_vivienda_propia          = $this->posee_vivienda_propia ?: null;
            $this->tiempo_en_ultimo_destino      = $this->tiempo_en_ultimo_destino ?: null;
            $this->destino_anterior               = $this->destino_anterior ?: null;
            $this->fecha_ultimo_ascenso           = $this->fecha_ultimo_ascenso ?: null;
            $this->horario_laboral                = $this->horario_laboral ?: null;
            $this->hace_adicionales               = $this->hace_adicionales ?: null;
            $this->anios_residencia_isla          = $this->anios_residencia_isla ?: null;

            $this->posee_oficio_profesion         = $this->posee_oficio_profesion ?: null;
            $this->situacion_laboral              = $this->situacion_laboral ?: null;
            $this->relacion_companieros_superiores = $this->relacion_companieros_superiores ?: null;
            $this->situacion_familiar             = $this->situacion_familiar ?: null;
            $this->ultimos_6_meses               = $this->ultimos_6_meses ?: null;
            $this->ultimos_dias_semanas          = $this->ultimos_dias_semanas ?: null;
            $this->pesadillas_trabajo            = $this->pesadillas_trabajo ?: null;

            $this->validate([
                'tipo_entrevista_id' => 'required|integer',
                'actitud_entrevista_id' => 'nullable|integer',
                'portacion_id' => 'nullable|integer',
                'salud_mentale_id' => 'nullable|integer',
                'estado_entrevista_id' => 'required|integer', // Solo para Postulante o Reintegro
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
                'causas_judiciales' => 'nullable|in:0,1', // Tiene causas judiciales (sí/no)
                'motivo_causas_judiciales' => 'nullable|string|max:500', // Motivo de las causas judiciales
                'sosten_de_familia' => 'nullable|in:0,1', // Sosten de familia
                'sosten_economico' => 'nullable|in:0,1', // Sosten económico
                'tiene_embargos' => 'nullable|in:0,1', // Sosten económico
                'enfermedad_preexistente' => 'nullable|in:0,1', // Enfermedad preexistente
                'medicacion' => 'nullable|string|max:500', // Medicación
                'realizo_tratamiento_psicologico' => 'nullable|in:0,1', // Realizó tratamiento psicológico
                'hace_cuanto_tratamiento_psicologico' => 'nullable|string|max:255', // Hace cuánto tratamiento psicológico
                'signos_y_sintomas' => 'nullable|string|max:1000', // Signos y síntomas
                'fecha' => 'nullable|date', // Fecha
                'profesional' => 'nullable|string|max:255', // Profesional
                'duracion' => 'nullable|string|max:255', // Duración
                'motivo' => 'nullable|string|max:255', // Motivo
                'medicacion_recetada' => 'nullable|string|max:500', // Medicación recetada
                'fuma' => 'nullable|in:0,1', // Fuma (sí/no)
                'cantidad_fuma' => 'nullable|integer', // Cantidad de cigarrillos si fuma
                'consume_alcohol' => 'nullable|in:0,1', // Consume alcohol (sí/no)
                'frecuencia_alcohol' => 'nullable|string|max:255', // Frecuencia de consumo de alcohol
                'consume_sustancias' => 'nullable|in:0,1', // Consume sustancias (sí/no)
                'tipo_sustancia' => 'nullable|string|max:255', // Tipo de sustancia
                'realiza_actividades' => 'nullable|in:0,1', // Realiza actividades (sí/no)
                'actividades' => 'nullable|string|max:1000', // Descripción de actividades
                'horas_suficientes' => 'nullable|in:0,1', // Horas suficientes de sueño (sí/no)
                'horas_dormir' => 'nullable|integer|between:0,24', // Horas de sueño
                'recomendacion' => 'nullable|in:0,1', // Recomendacion (sí/no)

                'posee_vivienda_propia'        => 'nullable|string|max:255',
                'tiempo_en_ultimo_destino'    => 'nullable|string|max:255',
                'destino_anterior'             => 'nullable|string|max:255',
                'fecha_ultimo_ascenso'         => 'nullable|date',
                'horario_laboral'              => 'nullable|string|max:255',
                'hace_adicionales'             => 'nullable|string|max:255',
                'anios_residencia_isla'        => 'nullable|string|max:255',

                'posee_oficio_profesion'       => 'nullable|string|max:255',
                'situacion_laboral'            => 'nullable|string|max:255',
                'relacion_companieros_superiores' => 'nullable|string|max:255',
                'situacion_familiar'           => 'nullable|string|max:1000',
                'ultimos_6_meses'             => 'nullable|string|max:1000',
                'ultimos_dias_semanas'        => 'nullable|string|max:1000',
                'pesadillas_trabajo'          => 'nullable|string|max:1000',

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
            $entrevista->portacion_id = $this->portacion_id ?? null;
            $entrevista->recomendacion = $this->recomendacion ?? null;
            $entrevista->salud_mentale_id = $this->salud_mentale_id ?? null;
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

            $entrevista->posee_vivienda_propia        = $this->posee_vivienda_propia;
            $entrevista->tiempo_en_ultimo_destino    = $this->tiempo_en_ultimo_destino;
            $entrevista->destino_anterior             = $this->destino_anterior;
            $entrevista->fecha_ultimo_ascenso         = $this->fecha_ultimo_ascenso;
            $entrevista->horario_laboral              = $this->horario_laboral;
            $entrevista->hace_adicionales             = $this->hace_adicionales;
            $entrevista->anios_residencia_isla        = $this->anios_residencia_isla;

            $entrevista->posee_oficio_profesion       = $this->posee_oficio_profesion;
            $entrevista->situacion_laboral            = $this->situacion_laboral;
            $entrevista->relacion_companieros_superiores = $this->relacion_companieros_superiores;
            $entrevista->situacion_familiar           = $this->situacion_familiar;
            $entrevista->ultimos_6_meses             = $this->ultimos_6_meses;
            $entrevista->ultimos_dias_semanas        = $this->ultimos_dias_semanas;
            $entrevista->pesadillas_trabajo          = $this->pesadillas_trabajo;

            $entrevista->save();


            // ✅ Registrar auditoría general
            audit_log(
                'entrevista.create',   // acción
                $entrevista,           // modelo afectado
                "Creación de entrevista"
            );

            $this->dispatch(
                'swal',
                title: 'Guardado',
                text:  'Entrevista registrada con éxito.',
                icon:  'success'
            );


            Log::debug('Valores antes de guardar entrevista', [
    'indicacionterapeutica_id' => $this->indicacionterapeutica_id,
    'abordaje_id' => $this->abordaje_id,
    // y todos los campos sospechosos...
]);


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
                'portacion_id',
                'recomendacion',
                'salud_mentale_id',
                'notas_clinicas',
                'tecnica_utilizada',
                'indicacionterapeutica_id',
                'abordaje_id',
                'derivacion_psiquiatrica',
                'evolucion_tratamiento',
                'aptitud_reintegro',
                'estado_entrevista_id',
                'paciente_id',
                'posee_vivienda_propia',
                'tiempo_en_ultimo_destino',
                'destino_anterior',
                'fecha_ultimo_ascenso',
                'horario_laboral',
                'hace_adicionales',
                'anios_residencia_isla',
                'posee_oficio_profesion',
                'situacion_laboral',
                'relacion_companieros_superiores',
                'situacion_familiar',
                'ultimos_6_meses',
                'ultimos_dias_semanas',
                'pesadillas_trabajo',
            ]);


        } catch (\Exception $e) {
            Log::error('Error al guardar la entrevista: ' . $e->getMessage());
            $this->dispatch(
                'swal',
                title: 'Revisá los campos',
                text:  'Completá Tipo de Entrevista y Estado de la Entrevista.',
                icon:  'error'
            );
        }


    }

    public function render()
    {
        return view('livewire.doctor.entrevista-form')->layout('layouts.app');
    }
}

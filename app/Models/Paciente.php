<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'apellido_nombre',
        'dni',
        'cuil',
        'genero',
        'direccion',
        'email',
        'telefono',
        'escalafon',
        'jerarquia',
        'legajo',
        'destino_actual',
        'ciudad_id',
        'edad',
        'fecha_nacimiento',
        'peso',
        'altura',
        'factore_id',
        'jerarquia_id',
        'estado_id',
        'fecha_atencion',
        'enfermedad',
        'remedios',
        'chapa',
        'NroCredencial',
        'sexo',
        'cuil1',
        'dni_bis',
        'cuil2',
        'TelefonoCelular',
        'TelefonoFijo',
        'domicilio',
        'CiudadDomicilio',
        'FecIngreso',
        'fecNacimiento',
        'FechaNombramiento',
        'EmailOfic',
        'antiguedad',
        'comisaria_servicio',
        'deleted_at',
        'created_at',
        'updated_at',
        'user_id'
    ];

    public function scopeSearch($query, $term)
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        // heuurísticas simples
        $isNumeric = ctype_digit($term);
        $isDate    = preg_match('/^\d{4}-\d{2}-\d{2}$/', $term); // YYYY-MM-DD

        return $query->where(function ($q) use ($term, $isNumeric, $isDate) {
            // Texto libre en campos propios
            $q->where('apellido_nombre', 'like', "%{$term}%")
            ->orWhere('destino_actual', 'like', "%{$term}%");

            // DNI / Legajo
            if ($isNumeric) {
                $q->orWhere('dni', $term)
                ->orWhere('legajo', $term)
                ->orWhere('id', $term); // opcional
            } else {
                $q->orWhere('dni', 'like', "%{$term}%")
                ->orWhere('legajo', 'like', "%{$term}%");
            }

            // Estados (relación)
            $q->orWhereHas('estados', function ($sub) use ($term) {
                $sub->where('name', 'like', "%{$term}%");
            });

            // Jerarquías (relación)
            $q->orWhereHas('jerarquias', function ($sub) use ($term) {
                $sub->where('name', 'like', "%{$term}%");
            });

            // Ciudades (relación) — en vez de ciudad_id LIKE
            $q->orWhereHas('ciudades', function ($sub) use ($term) {
                $sub->where('nombre', 'like', "%{$term}%");
            });

            // Disases (relación/pivot): por fecha o texto
            $q->orWhereHas('disases', function ($sub) use ($term, $isDate) {
                if ($isDate) {
                    $sub->whereDate('disase_paciente.fecha_finalizacion_licencia', $term);
                } else {
                    $sub->where('disase_paciente.fecha_finalizacion_licencia', 'like', "%{$term}%");
                }
            });
        });
    }


    // Relación 1 a 1 con Ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudade::class);
    }

    public function tratamientos()
    {

        return $this->hasMany(Paciente::class, 'paciente_id');
    }

    public function resultados()
    {

        return $this->hasMany(Paciente::class, 'paciente_id');
    }




    public function pdfhistoriales()
    {
        return $this->hasMany(Pdfhistorial::class);
    }

    // En el modelo Paciente
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jerarquias()
    {
        return $this->belongsTo('App\Models\Jerarquia', 'jerarquia_id', 'id');
    }
    public function tipolicencias()
    {
        return $this->belongsTo('App\Models\Tipolicenia', 'tipolicencia_id', 'id');
    }
    public function factores()
    {
        return $this->belongsTo('App\Models\Factore', 'factore_id', 'id');
    }

    public function estados()
    {
        return $this->belongsTo('App\Models\Estado', 'estado_id', 'id');
    }
    public function specialties()
    {
        return $this->belongsToMany(Especialidade::class);
    }

    public function socials()
    {
        return $this->belongsToMany(Social::class)->withPivot('url');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function offices()
    {
        return $this->hasMany(Oficina::class, 'doctor_id');
    }


    public function disases()
    {
        return $this->belongsToMany(Disase::class)->withPivot(
            'id', // <-- esto es fundamental para actualizar por certificado
            'fecha_presentacion_certificado',
            'detalle_certificado',
            'fecha_inicio_licencia',
            'fecha_finalizacion_licencia',
            'horas_salud',
            'suma_salud',
            'suma_auxiliar',
            'imagen_frente',
            'imagen_dorso',
            'estado_certificado',
            'tipodelicencia',
            'tipolicencia_id' // agregado acá
        )
            ->withTimestamps();
    }

    public function ciudades()
    {
        return $this->belongsTo(\App\Models\Ciudade::class, 'ciudad_id', 'id');
    }

    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class, 'paciente_id');
    }

    // En el modelo Paciente
    public function ultimaEntrevista()
    {
        return $this->hasOne(Entrevista::class)->latest(); // Obtiene la última entrevista por fecha
    }



    /*public function enfermeros()
    {
        return $this->belongsToMany(Enfermero::class)->withPivot('fecha_atencion', 'detalles', 'presion', 'glucosa', 'inyectable', 'dosis');
    }*/

    /* public function enfermeros(){

        return $this->hasMany(Paciente::class, 'paciente_id');

    }*/

    // En el modelo Paciente
    public function enfermeros()
    {
        return $this->hasMany(Enfermero::class);
    }

    public function ControlEnfermeros()
    {
        return $this->hasMany(Controlenfermero::class);
    }






    /* public function disases()
{
    return $this->belongsToMany(Disase::class, 'disase_paciente', 'paciente_id', 'disase_id')
        ->withPivot('tipo_enfermedad','fecha_enfermedad', 'fecha_atencion', 'fecha_finalizacion', 'horas_salud', 'archivo', 'activo', 'tipodelicencia'); // Agregar otros campos de la tabla intermedia que quieras mostrar
}estado_enfermedad*/

    public function enfermedades()
    {
        return $this->belongsToMany(Enfermedade::class, 'enfermedade_paciente', 'paciente_id', 'enfermedade_id')
            ->withPivot([
                'fecha_atencion_enfermedad',
                'fecha_finalizacion_enfermedad',
                'tipodelicencia',
                'detalle_diagnostico',
                'horas_reposo',
                'imgen_enfermedad',
                'pdf_enfermedad',
                'medicacion',
                'dosis',
                'detalle_medicacion',
                'motivo_consulta',
                'nro_osef',
                'art',
                'estado_enfermedad',
                'derivacion_psiquiatrica'
            ])
            ->withTimestamps();
    }



    /* public function enfermedadPacientes()
    {
        return $this->hasMany(Enfermedade_paciente::class, 'paciente_id');
    }*/

    public function surgeries()
    {
        return $this->belongsToMany(Surgery::class)->withPivot('fecha_enfermedad');
    }

    /**/
    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'paciente_symptom', 'paciente_id')->withPivot('interview_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withPivot('interview_id', 'instruction', 'dosage')->withTimestamps();
    }


    public function interviews()
    {
        return $this->hasMany(Interview::class, 'paciente_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }


    public function appoinments()
    {
        return $this->hasMany(Appoinment::class, 'patient_id');
    }

    public function pdfPsiquiatras()
    {
        return $this->hasMany(PdfPsiquiatra::class);
    }

    /*Agregado*/
    public function disasePivotById($certificadoId)
    {
        // Devuelve el pivot correspondiente al certificado
        return $this->disases->first(function ($disase) use ($certificadoId) {
            return $disase->pivot->id == $certificadoId;
        })?->pivot;
    }

    
}


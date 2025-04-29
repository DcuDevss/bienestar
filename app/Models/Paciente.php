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
        'ciudad',
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


    public function scopeSearch($query, $value)
    {
        $query->where('apellido_nombre', 'like', "%{$value}%")
            ->orWhere('dni', 'like', "%{$value}%")
            ->orWhere('legajo', 'like', "%{$value}%")
            ->orWhere('estado_id', 'like', "%{$value}%")
            ->orWhere('jerarquia_id', 'like', "%{$value}%")
            ->orWhere('destino_actual', 'like', "%{$value}%")
            ->orWhereHas('estados', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('jerarquias', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('disases', function ($query) use ($value) {
                $query->where('fecha_finalizacion_licencia', 'like', "%{$value}%");
            });
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
        );
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

    public function controlenfermeros()
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
        return $this->belongsToMany(Enfermedade::class)->withPivot('detalle_diagnostico', 'estado_enfermedad', 'derivacion_psiquiatrica', 'motivo_consulta', 'fecha_atencion_enfermedad', 'fecha_finalizacion_enfermedad', 'horas_reposo', 'imgen_enfermedad', 'pdf_enfermedad', 'medicacion', 'dosis', 'detalle_medicacion', 'nro_osef', 'art', 'tipodelicencia');
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
}

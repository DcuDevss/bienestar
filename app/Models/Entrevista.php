<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    use HasFactory;

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
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
        'portacion_id',
        'recomendacion',
        'salud_mental_id',
        'estado_entrevista_id',
        'paciente_id',
        'user_id',
    ];

    public function scopeSearch($query, $value)
    {
        return $query->where(function ($query) use ($value) {
            $query->whereHas('tipoEntrevista', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            })
            ->orWhere('posee_arma', '=', strtolower($value) == 'si' ? 1 : (strtolower($value) == 'no' ? 0 : null))
            ->orWhere('created_at', 'like', "%{$value}%");
        });
    }


    // Relación con TipoEntrevista
    public function tipoEntrevista()
    {
        return $this->belongsTo(TipoEntrevista::class);
    }

    // Relación con ActitudEntrevista
    public function actitudEntrevista()
    {
        return $this->belongsTo(ActitudEntrevista::class);
    }

    // Relación con EstadoEntrevista
    public function estadoEntrevista()
    {
        return $this->belongsTo(EstadoEntrevista::class);
    }

    // Relación con GrupoFamiliar
    public function grupoFamiliar()
    {
        return $this->hasMany(GrupoFamiliar::class);
    }

    // Relación con Usuario (usuario que realizó la entrevista)
    public function user()
    {
        return $this->belongsTo(User::class);  // Suponiendo que el modelo del usuario es 'User'
    }

    // Relación con IndicacionTerapéuticas
    public function indicacionterapeutica()
    {
        return $this->belongsTo(IndicacionTerapeutica::class);
    }


    // Relación con Abordaje
    public function abordaje()
    {
        return $this->belongsTo(Abordaje::class);
    }

    public function TecnicaUtiliza()
    {
        return $this->belongsTo(TecnicaUtilizada::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function portacion()
    {
        return $this->belongsTo(Portacion::class);
    }

    public function saludmentale()
    {
        return $this->belongsTo(SaludMentale::class, 'salud_mental_id');
    }

}

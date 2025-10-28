<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasePaciente extends Model
{
    protected $table = 'disase_paciente'; // 👈 noombre correcto de la tabla pivot

    protected $fillable = [
        'fecha_presentacion_certificado',
        'fecha_inicio_licencia',
        'fecha_finalizacion_licencia',
        'horas_salud',
        'suma_salud',
        'suma_auxiliar',
        'detalle_certificado',
        'imagen_frente',
        'imagen_dorso',
        'estado_certificado',
        'disase_id',
        'paciente_id',
        'tipodelicencia',
        'tipolicencia_id',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tipolicencia()
    {
        return $this->belongsTo(Tipolicencia::class);
    }

    public function disase()
    {
        return $this->belongsTo(Disase::class);
    }
}

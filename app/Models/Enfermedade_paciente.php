<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedade_paciente extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_atencion2',
        'detalle_enfermedad2',
        'horas_reposo2',
        'paciente_id',
        'enfermedade_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function enfermedad()
    {
        return $this->belongsTo(Enfermedade::class, 'enfermedade_id');
    }
}

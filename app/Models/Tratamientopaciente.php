<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TratamientoPaciente extends Model
{
    use HasFactory;

    // Dentro del modelo Tratamientopaciente
public function enfermedadePaciente()
{
    return $this->belongsTo(EnfermedadePacien::class, 'enfermedade_paciente_id');
}

public function getEnfermedadePacienteIdAttribute()
{
    return $this->enfermedadePaciente ? $this->enfermedadePaciente->id : null;
}
}

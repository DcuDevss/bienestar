<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;


    protected $fillable = [
        'profesional_actual',
        'consumo_farmacos',
        'antecedente_familiar',
        'fecha_inicio',
        'profesional_enterior',
        'fecha_anterior',
        'motivo_consulta_anterior',
        'motivo_consulta_actual',
        'tipolicencia_id',
        'indicacionterapeutica_id',
        'derivacionpsiquiatrica_id',
        'procedencia_id',
        'enfermedade_id',
        'paciente_id',
        'fecha_atencion'


    ];



    public function tipolicencias()
    {
        return $this->belongsTo('App\Models\Tipolicencia', 'tipolicencia_id', 'id');
    }
    public function procedencias()
    {
        return $this->belongsTo('App\Models\Procedencia', 'procedencia_id', 'id');
    }
    public function derivacionpsiquiatricas()
    {
        return $this->belongsTo('App\Models\DerivacionPsiquiatrica', 'derivacionpsiquiatrica_id', 'id');
    }
    public function indicacionterapeuticas()
    {
        return $this->belongsTo('App\Models\IndicacionTerapeutica', 'indicacionterapeutica_id', 'id');
    }
    public function pacientes()
    {
        return $this->belongsTo('App\Models\Paciente', 'paciente_id', 'id');
    }
    public function enfermedades()
    {
        return $this->belongsTo('App\Models\Enfermedade', 'enfermedade_id', 'id');
    }

    public function resultados()
    {
        return $this->belongsTo('App\Models\Resultado', 'resultado_id', 'id');
    }



}

/* comentario */

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;


    protected $fillable=[

        'resultado_tratamiento',
        'analisis_clinicos',
        'fecha_atencion',
        'detalle_tratamiento',
        'status',
        'trtatamiento_id',
        'paciente_id',
    ];

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Paciente', 'paciente_id', 'id');
    }
    public function tratamientos()
    {
        return $this->belongsTo('App\Models\Tratamiento', 'tratamiento_id', 'id');
    }




}

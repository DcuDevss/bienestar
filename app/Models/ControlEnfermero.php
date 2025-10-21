<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlEnfermero extends Model
{
    use HasFactory;
        protected $table = 'controlenfermeros'; // <<-- NOMBRE REAL EN BD

    protected $fillable = [
        'presion',
        'glucosa',
        'inyectable',
        'temperatura',
        'dosis',
        'fecha_atencion',
        'detalles',
        'paciente_id',

    ];
  


    public function paciente()
{
    return $this->belongsTo(Paciente::class);
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlEnfermero extends Model
{
    use HasFactory;
        protected $table = 'controlenfermeros'; // <<-- NOoMBRE REAL EN BD, se realizaron cambios bien en todo

    protected $fillable = [
        'presion',
        'glucosa',
        'inyectable',
        'temperatura',
        'dosis',
        'fecha_atencion',
        'detalles',
        'paciente_id',
        'peso',
        'altura',
        'talla',

    ];



    public function paciente()
{
    return $this->belongsTo(Paciente::class);
}

}

<?php

namespace App\Models;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSesion extends Model
{
    use HasFactory;

    // Ajusta el nombre de la tabla si usas plural diferente (ej: 'registros_sesiones')
    protected $table = 'registro_sesiones';

    protected $fillable = [
        'paciente_id',
        'sesion_nro',
        'fecha_sesion',
        'tratamiento_fisiokinetico',
        'evolucion_sesion',
        
    ];

    protected $casts = [
        'fecha_sesion' => 'date',
    ];

    // Relación: Una sesión pertenece a un Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}

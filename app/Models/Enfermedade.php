<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedade extends Model
{


    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'codigo',
    ];

    /* public static fuunction search($search){
        return empty($search) ? static::query()
        : static::where('id',$search)
        ->orWhere('name','like','%'.$search.'%')
        ->orWhere('enfermedade_paciente.detalle_enfermedad1','like','%'.$search.'%')
        ->orWhere('enfermedade_paciente.horas_reposo1','like','%'.$search.'%')
        //->orWhere('','like','%'.$search.'%')
        ->orWhere('enfermedade_paciente.fecha_atencion1','like','%'.$search.'%');
    }*/ //,'estado_enfermedad'
    /* */

    /* public static function search($search){
    return empty($search) ? static::query()
    : static::where('id',$search)
    ->orWhere('name','like','%'.$search.'%');

    }*/


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::where('id', $search)
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('codigo', 'like', '%' . $search . '%');
    }


    /* public function tratamientos()
    {

        return $this->hasMany(Enfermedade::class, 'enfermedade_id');
    } */

    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class)->withPivot('detalle_diagnostico', 'fecha_atencion_enfermedad','estado_enfermedad','derivacion_psiquiatrica', 'fecha_finalizacion_enfermedad', 'horas_reposo','motivo_consulta', 'imgen_enfermedad', 'pdf_enfermedad', 'medicacion', 'dosis', 'detalle_medicacion', 'nro_osef', 'art', 'tipodelicencia');
    }

    /* public function pacientes()
    {
        return $this->belongsToMany(Paciente::class, 'enfermedade_paciente', 'enfermedade_id', 'paciente_id')
            ->withPivot('detalle_diagnostico', 'fecha_atencion_enfermedad', 'fecha_finalizacion_enfermedad', 'horas_reposo', 'imgen_enfermedad', 'pdf_enfermedad', 'medicacion', 'dosis', 'detalle_medicacion', 'nro_osef', 'tipodelicencia')
            ->withTimestamps();
    }*/
    public function tipolicencias()
    {
        return $this->belongsTo('App\Models\Tipolicencia', 'tipolicencia_id', 'id');
    }
    /*public function enfermedadPacientes()
    {
        return $this->hasMany(Enfermedade_paciente::class, 'enfermedad_id');
    }*/
    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}

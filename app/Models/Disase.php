<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disase extends Model
{
    protected $fillable =['name','slug','symptoms','tipolicencia_id'];
    use HasFactory;


    public static function search($search){
        return empty($search) ? static::query()
        : static::where('id',$search)
        ->orWhere('name','like','%'.$search.'%');
       // ->orWhere('symtoms','like','%'.$search.'%');
    }

    public function pacientes(){
        return $this->belongsToMany(Paciente::class)->withPivot('fecha_presentacion_certificado','detalle_certificado','fecha_inicio_licencia','fecha_finalizacion_licencia','horas_salud','suma_salud','suma_auxiliar','imagen_frente','imagen_dorso','estado_certificado','tipodelicencia');
    }
    public function tipolicencias()
    {
        return $this->belongsTo('App\Models\Tipolicencia', 'tipolicencia_id', 'id');
    }
}

/*namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disase extends Model
{
    protected $fillable = ['name', 'slug', 'symptoms', 'tipolicencia_id'];
    use HasFactory;




    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class)->withPivot('fecha_enfermedad', 'tipo_enfermedad', 'fecha_atencion', 'fecha_finalizacion', 'horas_salud', 'archivo', 'activo', 'tipodelicencia');
    }
}*/


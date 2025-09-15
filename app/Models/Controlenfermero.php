<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlEnfermero extends Model
{
    use HasFactory;
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
    /*
    public function scopeSearch($query, $value)
    {
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('presion', 'like', "%{$value}%")
            ->orWhere('temperatura', 'like', "%{$value}%")
            ->orWhere('glucosa', 'like', "%{$value}%")
            ->orWhere('fecha_actual', 'like', "%{$value}%")
            ->orWhere('dosis', 'like', "%{$value}%")
            ->orWhere('detalles', 'like', "%{$value}%");

    }
    public static function search($search){
        return empty($search) ? static::query()
        : static::where('id',$search)
        ->orWhere('presion','like','%'.$search.'%');
       // ->orWhere('symtoms','like','%'.$search.'%');
    }*/


    public function paciente()
{
    return $this->belongsTo(Paciente::class);
}

}

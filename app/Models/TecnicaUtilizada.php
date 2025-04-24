<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TecnicaUtilizada extends Model
{
    use HasFactory;

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'name',  // Nombre de la técnica (Cognitivo Conductual, etc.)
    ];

    // Relación inversa con la tabla Entrevistas
    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}

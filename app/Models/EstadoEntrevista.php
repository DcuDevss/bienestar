<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEntrevista extends Model
{
    use HasFactory;

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'name',  // Apto, No Apto, Condicional
    ];

    // Relación iinversa con la taabla Entrevistas
    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}


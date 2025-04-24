<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoFamiliar extends Model
{
    use HasFactory;
    protected $table = 'grupo_familiares'; 

    protected $fillable = ['entrevista_id', 'nombre', 'edad', 'ocupacion', 'parentesco', 'antecedentes_psiquiatricos'];

    public function entrevista()
    {
        return $this->belongsTo(Entrevista::class);
    }
}


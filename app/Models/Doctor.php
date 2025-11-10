<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nro_matricula', 'especialidad'];
    

    // Relación: un doctor puede tener muchas fichas kinesiológicas
    public function fichas()
    {
        return $this->hasMany(FichaKinesiologica::class);
    }
}

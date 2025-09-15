<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicacionTerapeutica extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación inversa con la tabla Entrevistas
    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}

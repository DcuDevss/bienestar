<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudade extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'cp'];

    // Relación 1 a 1 inversa caon Paciente
    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }

}

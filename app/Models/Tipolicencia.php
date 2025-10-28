<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipolicencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',


    ];

    public function tratamientos(){

        return $this->hasMany(Tipolicencia::class, 'tipolicencia_id');

    }


    public function paciente(){

        return $this->hasMany(Paciente::class, 'tipolicencia_id');

    }

    public function disases(){

        return $this->hasMany(Disase::class, 'tipolicencia_id');

    }
    public function enferemdades(){

        return $this->hasMany(Enfermedade::class, 'tipolicencia_id');

    }

    /*public function disases_pacieentes(){

        return $this->hasMany(Disase_paciente::class, 'tipolicencia_id');

    }*/
    public function disases_paciente()
{
    return $this->hasMany(\App\Models\DisasePaciente::class, 'tipolicencia_id');
}

}



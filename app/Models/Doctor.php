<?php

namespace App\Models;

use App\Scopes\DoctorScope;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

class Doctor extends User //aqui iba el model pero ahora va heredar de user
{
    //use HasFactory;

    //esto hace que cada ves que pidamos un doctor, se va usar el globalscope para verifica que el doctor tenga las retrecciones q le demos
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DoctorScope);
    }

    public function workdays(){
        return $this->hasMany(Diadetrabajo::class);
    }

    public function appoinments(){
        return $this->hasMany(Appoinment::class);
    }



    public function specialties(){
        return $this->belongsToMany('App\Models\Especialidade', 'especialidade_user', 'user_id', 'especialidade_id');
    }


    public function offices(){
        return $this->hasMany('App\Models\User','oficinas','doctor_id');
    }
}

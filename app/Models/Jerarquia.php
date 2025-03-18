<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jerarquia extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',

    ];

    public function user(){

        return $this->hasMany(User::class, 'jerarquia_id');

    }

    public function paciente(){

        return $this->hasMany(Paciente::class, 'jerarquia_id');

    }



}

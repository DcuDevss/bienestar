<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'descripcion',

    ];


    public function doctors(){//una especialidad tiene muchos medicos 
        return $this->belongsToMany(User::class);
    }
}

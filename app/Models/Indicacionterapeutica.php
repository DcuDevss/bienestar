<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicacionterapeutica extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación inversa con la tabla Entrevistass
    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}

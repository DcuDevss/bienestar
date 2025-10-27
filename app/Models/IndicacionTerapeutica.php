<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicacionTerapeutica extends Model
{
    use HasFactory;
    /* forma correcta de indicar la tabla vamos */
    protected $table = 'indicacionterapeuticas';

    protected $fillable = ['name'];

    // Relación inversa con la tabla Entrevistasss
    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}

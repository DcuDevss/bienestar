<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DerivacionPsiquiatrica extends Model
{
    use HasFactory;
        protected $table = 'derivacionpsiquiatricas';

    protected $fillable=['name'];
    public function tratamientos(){

        return $this->hasMany(DerivacionPsiquiatrica::class, 'Derivacionpsiquiatrica_id');

    }
}
/* cambioo */

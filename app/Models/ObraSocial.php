<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $table = 'obra_socials';

    use HasFactory;

    protected $fillable = [
        'name',
        'telefono_contacto',
        'email_contacto',
    ];

    // Relación: una obra social puede tener muchas fichas
    public function fichas()
    {
        return $this->hasMany(FichaKinesiologica::class);
    }
}

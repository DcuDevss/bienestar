<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicacionterapeutica extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tratamientos(){

        return $this->hasMany(Indicacionterapeutica::class, 'indicacionterapeutica_id');

    }
}

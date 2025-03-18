<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedencia extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function tratamientos(){

        return $this->hasMany(Procedencia::class, 'procedencia_id');

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portacion extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }
}

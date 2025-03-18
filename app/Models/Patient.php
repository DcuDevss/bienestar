<?php

namespace App\Models;

use App\Scopes\PatientScope;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

class Patient extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PatientScope);
    }
}

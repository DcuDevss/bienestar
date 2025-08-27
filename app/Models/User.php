<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];
    protected $table = "users"; //esto es para que laravel recocnsa quien es el usuraio el doctor y paciente
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    // En el modelo User
    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }


    public function specialties()
    {
        return $this->belongsToMany(Especialidade::class);
    }


    public function socials()
    {
        return $this->belongsToMany(Social::class)->withPivot('url');
    }


    public function jerarquia()
    {
        return $this->belongsTo('App\Models\Jerarquia', 'jerarquia_id', 'id');
    }
    public function factore()
    {
        return $this->belongsTo('App\Models\Factore', 'factore_id', 'id');
    }

    public function offices()
    {
        return $this->hasMany(Oficina::class, 'doctor_id');
    }

    public function appoinments()
    {
        return $this->hasMany(Appoinment::class, 'patient_id');
    }

    public function disases()
    {
        return $this->belongsToMany(Disase::class)->withPivot('year');
    }
    
}

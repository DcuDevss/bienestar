<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Cristian Retamar',
            'email'=>'retacris30@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole(['super-admin','admin-jefe','administrativo','doctor','psicologa','enfermero']);
        //->roles()->synnc('1');

        User::create([
            'name'=>'Sergio Ramos',
            'email'=>'ramos_sergio20@hotmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole(['super-admin','admin-jefe','administrativo','doctor','psicologa','enfermero']);
        //->roles()->sync('1'), si se peude ;

        User::create([
            'name'=>'Jefa',
            'email'=>'jefa@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('admin-jefe');
        //->roles()->sync('2');

        User::create([
            'name'=>'administrativo',
            'email'=>'administrativo@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('administrativo');
        //->roles()->sync('3');

        User::create([
            'name'=>'doctor1',
            'email'=>'doctor1@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('doctor');
        //->roles()->sync('4');

        User::create([
            'name'=>'doctor2',
            'email'=>'doctor2@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('doctor');
        //->roles()->sync('4');

        User::create([
            'name'=>'psicologa',
            'email'=>'psicologa@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('psicologa');
        //->roles()->sync('5');

        User::create([
            'name'=>'enfermero',
            'email'=>'enfermero@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('enfermero');
        //->roles()->sync('7');

        User::create([
            'name'=>'Victor Quispe',
            'email'=>'informatica.dcu@gmail.com',
            'password'=>bcrypt('12345678'),
            'email_verified_at'=>now(),
        ])->assignRole('user_policia');
        //->roles()->sync('9');

       // User::factory(50)->create();
       /* User::factory(100)->create()->each(function($user){
            $user->assignRole('user_civil');
        });

        User::factory(10)->create()->each(function($user){
            $user->assignRole('doctor');
        });

        User::factory(100)->create()->each(function($user){
            $user->assignRole('user_policia');
        });*/
    }
}

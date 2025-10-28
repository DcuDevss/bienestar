<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AsignarCiudadId extends Command
{
    protected $signature = 'pacientes:asignar-ciudad-id';
    protected $description = 'Asigna ciudad_id a pacientes según el valor del campo ciudad';

    public function handle()
    {
        $pacientes = DB::table('pacientes')->get();

        foreach ($pacientes as $paciente) {
            $ciudad = strtolower($paciente->ciudad ?? '');
            
            if (str_starts_with($ciudad, 'u')) {
                $id = 1;
            } elseif (str_starts_with($ciudad, 't')) {
                $id = 2;
            } else {
                $id = 3;
            }

            DB::table('pacientes')
                ->where('id', $paciente->id)
                ->update(['ciudad_id' => $id]);
        }

        $this->info('Campo ciudad_id actualizado correctamente.');
    }
}

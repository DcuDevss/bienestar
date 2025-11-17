<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ObraSocial;

class ObraSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $this->call(ObraSocialSeeder::class); */
        $obrasSociales = [
            ['nombre' => 'OSEF – Obra Social del Estado Fueguino', 'telefono_contacto' => '02901-42-1100', 'email_contacto' => 'contacto@osef.gob.ar'],
            ['nombre' => 'PAMI – Instituto Nacional de Servicios Sociales para Jubilados y Pensionados', 'telefono_contacto' => '0800-222-7264', 'email_contacto' => 'atencion@pami.org.ar'],
            ['nombre' => 'I.O.M.A. – Instituto de Obra Social de la Provincia de Buenos Aires', 'telefono_contacto' => '0800-666-4662', 'email_contacto' => 'info@ioma.gba.gov.ar'],
            ['nombre' => 'Federada Salud – Mutual 25 de Junio', 'telefono_contacto' => '0810-888-8888', 'email_contacto' => 'info@federada.com'],
            ['nombre' => 'I.O.S.P.E.R. – Instituto de Obra Social de la Provincia de Entre Ríos', 'telefono_contacto' => '0343-420-7800', 'email_contacto' => 'info@iosper.gov.ar'],
            ['nombre' => 'A.P.R.O.S.S. – Administración Provincial del Seguro de Salud (Córdoba)', 'telefono_contacto' => '0800-888-2776', 'email_contacto' => 'contacto@apross.gov.ar'],
            ['nombre' => 'O.S.P.M. – Obra Social del Personal Mosaísta', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'OSTCARA – Obra Social de los Trabajadores de la Carne y Afines de la República Argentina', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. de Operadores Cinematográficos', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. del Personal de Distribuidoras Cinematográficas de la República Argentina', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. de Músicos', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'ANDAR – Obra Social de los Viajantes Vendedores de la República Argentina', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. del Personal de la Industria del Vidrio', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. de Peones de Taxis de la Capital Federal', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. de Conductores de Remises y Autos al Instante y Afines', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'OSSEG – Obra Social del Personal de la Actividad de Seguros, Reaseguros y Capitalización', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'O.S. de Y.P.F.', 'telefono_contacto' => null, 'email_contacto' => null],
            ['nombre' => 'ACA Salud – Asociación Cooperadora de Ahorro y Crédito de la República Argentina', 'telefono_contacto' => '0810-222-7225', 'email_contacto' => 'info@acasalud.com.ar'],
            ['nombre' => 'OSDE – Obra Social de Ejecutivos y Directivos Empresarios', 'telefono_contacto' => '0810-555-6733', 'email_contacto' => 'info@osde.com.ar'],
            ['nombre' => 'Medife – Medicina Integral de la Federación Económica Argentina', 'telefono_contacto' => '0810-333-6334', 'email_contacto' => 'contacto@medife.com.ar'],
            ['nombre' => 'OMINT – Organización de Medicina Integral', 'telefono_contacto' => '0810-666-6468', 'email_contacto' => 'info@omint.com.ar'],
        ];

        foreach ($obrasSociales as $obra) {
            ObraSocial::create($obra);
        }
    }
}

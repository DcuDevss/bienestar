<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EspecialidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Especialidade::create(["name" => "clinico general", "slug" => Str::slug("clinico general")]);
        Especialidade::create(["name" => "psicologia", "slug" => Str::slug("psicologia")]);
        Especialidade::create(["name" => "traumatologia", "slug" => Str::slug("traumatologia")]);
        Especialidade::create(["name" => "diabetologia", "slug" => Str::slug("diabetologia")]);
        Especialidade::create(["name" => "alergia", "slug" => Str::slug("alergia")]);
        Especialidade::create(["name" => "anatomia patologica", "slug" => Str::slug("anatomia patologica")]);
        Especialidade::create(["name" => "anestesia", "slug" => Str::slug("anestesia")]);
        Especialidade::create(["name" => "angiologia general y hemodinamia", "slug" => Str::slug("angiologia general y hemodinamia")]);
        Especialidade::create(["name" => "bacteriologia", "slug" => Str::slug("bacteriologia")]);
        Especialidade::create(["name" => "cardiologia infantil", "slug" => Str::slug("cardiologia infantil")]);
        Especialidade::create(["name" => "cardiologia", "slug" => Str::slug("cardiologia")]);
        Especialidade::create(["name" => "cirugia plastica y reparadora", "slug" => Str::slug("cirugia plastica y reparadora")]);
        Especialidade::create(["name" => "cirugia toracica", "slug" => Str::slug("cirugia toracica")]);
        Especialidade::create(["name" => "cirugia de cabeza y cuello", "slug" => Str::slug("cirugia de cabeza y cuello")]);
        Especialidade::create(["name" => "cirugia general", "slug" => Str::slug("cirugia general")]);
        Especialidade::create(["name" => "cirugia cardiovascular", "slug" => Str::slug("cirugia cardiovascular")]);
        Especialidade::create(["name" => "cirugia vascular periferica", "slug" => Str::slug("cirugia vascular periferica")]);
        Especialidade::create(["name" => "cirugia infantil", "slug" => Str::slug("cirugia infantil")]);
        Especialidade::create(["name" => "clinica medica medicina interna", "slug" => Str::slug("clinica medica medicina interna")]);
        Especialidade::create(["name" => "dermatologia", "slug" => Str::slug("dermatologia")]);
        Especialidade::create(["name" => "dermatosifilografia", "slug" => Str::slug("dermatosifilografia")]);
        Especialidade::create(["name" => "diagnostico por imagenes", "slug" => Str::slug("diagnostico por imagenes")]);
        Especialidade::create(["name" => "endocrinologia", "slug" => Str::slug("endocrinologia")]);
        Especialidade::create(["name" => "endoscopia digestiva", "slug" => Str::slug("endoscopia digestiva")]);
        Especialidade::create(["name" => "enfermedades infecciosas => infectología", "slug" => Str::slug("enfermedades infecciosas => infectología")]);
        Especialidade::create(["name" => "epidemiologia", "slug" => Str::slug("epidemiologia")]);
        Especialidade::create(["name" => "farmacologia", "slug" => Str::slug("farmacologia")]);
        Especialidade::create(["name" => "fisitria medicina física y rehabilitación", "slug" => Str::slug("fisitria medicina física y rehabilitación")]);
        Especialidade::create(["name" => "gastroenterologia", "slug" => Str::slug("gastroenterologia")]);
        Especialidade::create(["name" => "genetica medica", "slug" => Str::slug("genetica medica")]);
        Especialidade::create(["name" => "geriatria", "slug" => Str::slug("geriatria")]);
        Especialidade::create(["name" => "ginecologia", "slug" => Str::slug("ginecologia")]);
        Especialidade::create(["name" => "hematologia", "slug" => Str::slug("hematologia")]);
        Especialidade::create(["name" => "hemoterapia e inmunohematologia", "slug" => Str::slug("hemoterapia e inmunohematologia")]);
        Especialidade::create(["name" => "hemoterapia", "slug" => Str::slug("hemoterapia")]);
        Especialidade::create(["name" => "higiene industrial", "slug" => Str::slug("higiene industrial")]);
        Especialidade::create(["name" => "higiene y medicina preventiva", "slug" => Str::slug("higiene y medicina preventiva")]);
        Especialidade::create(["name" => "inmunologia", "slug" => Str::slug("inmunologia")]);
        Especialidade::create(["name" => "leprologia", "slug" => Str::slug("leprologia")]);
        Especialidade::create(["name" => "mastologia", "slug" => Str::slug("mastologia")]);
        Especialidade::create(["name" => "medicina legal", "slug" => Str::slug("medicina legal")]);
        Especialidade::create(["name" => "medicina nuclear", "slug" => Str::slug("medicina nuclear")]);
        Especialidade::create(["name" => "medicina sanitaria", "slug" => Str::slug("medicina sanitaria")]);
        Especialidade::create(["name" => "medicina del trabajo", "slug" => Str::slug("medicina del trabajo")]);
        Especialidade::create(["name" => "medicina familiar", "slug" => Str::slug("medicina familiar")]);
        Especialidade::create(["name" => "medicina aeronautica y espacial", "slug" => Str::slug("medicina aeronautica y espacial")]);
        Especialidade::create(["name" => "medicina del deporte", "slug" => Str::slug("medicina del deporte")]);
        Especialidade::create(["name" => "nefrologia", "slug" => Str::slug("nefrologia")]);
        Especialidade::create(["name" => "neonatologia", "slug" => Str::slug("neonatologia")]);
        Especialidade::create(["name" => "neumonologia", "slug" => Str::slug("neumonologia")]);
        Especialidade::create(["name" => "neurocirugia", "slug" => Str::slug("neurocirugia")]);
        Especialidade::create(["name" => "neurologia infantil", "slug" => Str::slug("neurologia infantil")]);
        Especialidade::create(["name" => "neurologia", "slug" => Str::slug("neurologia")]);
        Especialidade::create(["name" => "nutricion", "slug" => Str::slug("nutricion")]);
        Especialidade::create(["name" => "obstetricia", "slug" => Str::slug("obstetricia")]);
        Especialidade::create(["name" => "oftalmologia", "slug" => Str::slug("oftalmologia")]);
        Especialidade::create(["name" => "oncologia (clínica)", "slug" => Str::slug("oncologia (clínica)")]);
        Especialidade::create(["name" => "ortopedia y traumatologia", "slug" => Str::slug("ortopedia y traumatologia")]);
        Especialidade::create(["name" => "otorrinolaringologia", "slug" => Str::slug("otorrinolaringologia")]);
        Especialidade::create(["name" => "pediatria (clínica pediátrica)", "slug" => Str::slug("pediatria (clínica pediátrica)")]);
        Especialidade::create(["name" => "proctologia", "slug" => Str::slug("proctologia")]);
        Especialidade::create(["name" => "psicologia medica (clínica)", "slug" => Str::slug("psicologia medica (clínica)")]);
        Especialidade::create(["name" => "psiquiatria", "slug" => Str::slug("psiquiatria")]);
        Especialidade::create(["name" => "psiquiatria infantil", "slug" => Str::slug("psiquiatria infantil")]);
        Especialidade::create(["name" => "quemados", "slug" => Str::slug("quemados")]);
        Especialidade::create(["name" => "radiologia", "slug" => Str::slug("radiologia")]);
        Especialidade::create(["name" => "radioterapia (terapia radiante)", "slug" => Str::slug("radioterapia (terapia radiante)")]);
        Especialidade::create(["name" => "reumatologia", "slug" => Str::slug("reumatologia")]);
        Especialidade::create(["name" => "salud publica", "slug" => Str::slug("salud publica")]);
        Especialidade::create(["name" => "terapia intensiva", "slug" => Str::slug("terapia intensiva")]);
        Especialidade::create(["name" => "tisiologia", "slug" => Str::slug("tisiologia")]);
        Especialidade::create(["name" => "tisioneumonologia", "slug" => Str::slug("tisioneumonologia")]);
        Especialidade::create(["name" => "tocoginecologia", "slug" => Str::slug("tocoginecologia")]);
        Especialidade::create(["name" => "toxicologia", "slug" => Str::slug("toxicologia")]);
        Especialidade::create(["name" => "urologia", "slug" => Str::slug("urologia")]);




      

       /* $json = File::get('database/data/especialidades.json');
       $data = json_decode($json);
       foreach($data as $obj){
           $specialty = new Especialidade();
           $specialty->name = mb_strtolower($obj->name);
           $specialty->slug = Str::slug($obj->name);
           $specialty->save();
       }

       $doctors = User::role(['doctor'])->get();
       foreach($doctors as $doctor){
         $numero = random_int(1,4);
         $specialties = Especialidade::inRandomOrder()->limit($numero)->pluck('id');
         $doctor->specialties()->sync($specialties);
       }*/



    }
}

<?php

namespace Database\Seeders;

use App\Models\Enfermedade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EnfermedadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   /* public function run(): void
    {
        $json = File::get('database/data/disases.json');
        $data = json_decode($json);
        foreach($data as $obj){
            $disase = new Enfermedade();
            $disase->name = mb_strtolower($obj->name);
            $disase->slug = Str::slug($obj->name); $disase->name = $obj->name;
            $disase->symptoms = $obj->symptoms;
            $disase->save();//mb_strtolower($obj->name);
           // $disase->slug = Str::slug($obj->name);
        }
    }*/
      public function run(): void
    {
        $json = File::get('database/data/enfermedades.json');
        $data = json_decode($json);
        foreach($data as $obj){
            $disase = new Enfermedade();
            $disase->codigo = $obj->codigo;
            $disase->name = mb_strtolower($obj->name);
            $disase->slug = Str::slug($obj->name);
            $disase->save();
        }
    }
}

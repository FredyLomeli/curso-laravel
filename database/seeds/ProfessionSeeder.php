<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO professions (name) values (:name)', 
        ['name' => 'Desarrollador Java.']);

        DB::table('professions')->insert([
            'name' => 'Desarrollador Front-end.',
        ]);

        DB::table('professions')->insert([
            'name' => 'Diseñador Web.',
        ]);

        Profession::create(['name' => 'Desarrollador Back-end.',]);

        factory(Profession::class,46)->create();
    }
}

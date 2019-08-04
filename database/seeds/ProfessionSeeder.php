<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO profession (name) values (:name)', 
            ['name' => 'Desarrollador Java']);

        DB::table('profession')->insert([
            'name' => 'Desarrollador Back-end.',
        ]);

        DB::table('profession')->insert([
            'name' => 'Desarrollador Front-end.',
        ]);

        DB::table('profession')->insert([
            'name' => 'Diseñador Web.',
        ]);
    }
}

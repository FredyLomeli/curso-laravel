<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = DB::table('profession')
        ->select('id')
        ->whereName('Desarrollador Back-end.')
        ->value('id');

        // dd($professionId);

        DB::table('users')->insert([
            'name' => 'Alfredo Lomeli',
            'email' => 'ing.lomeli@gmail.com',
            'password' => bcrypt('laravel'),
            'profession_id' => $professionId,
        ]);
    }
}

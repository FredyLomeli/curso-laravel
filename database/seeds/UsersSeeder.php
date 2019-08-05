<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Profession;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = DB::table('professions')
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

        $professionId = Profession::select('id')
            ->where('name','Desarrollador Front-end.')->value('id');

        User::create([
            'name' => 'Alejandra Navaro',
            'email' => 'alejandra.navarro@gmail.com',
            'password' => bcrypt('laravel'),
            'profession_id' => $professionId,
        ]);

        $professionId = Profession::select('id')
        ->where('name','Desarrollador Java.')->value('id');

        User::create([
            'name' => 'Pyboby Lomeli Navarro',
            'email' => 'Pyboby@chiquis.com',
            'password' => bcrypt('guau'),
            'profession_id' => $professionId,
        ]);

        factory(User::class,47)->create();
    }
}

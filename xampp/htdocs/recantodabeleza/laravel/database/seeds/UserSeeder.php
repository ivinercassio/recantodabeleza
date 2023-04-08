<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Deisymar Botega',
            'email' => 'dbotegatavares@gmail.com',
            'password' => bcrypt('123456'),
            'cdFuncionario' => 1
        ]);

        User::create([
            'name' => 'Emanuelly Carvalho',
            'email' => 'manu.eu.2022@gmail.com',
            'password' => bcrypt('123456'),
            'cdFuncionario' => 2
        ]);

        User::create([
            'name' => 'Fernando Souza',
            'email' => 'fernandoSouza@gmail.com',
            'password' => bcrypt('123456'),
            'cdFuncionario' => 3
        ]);

        User::create([
            'name' => 'Lorena Souza',
            'email' => 'itsMeLorena@gmail.com',
            'password' => bcrypt('123456'),
            'cdFuncionario' => 4
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\ModelClient;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(ModelClient::class, 3)->create();

        ModelClient::create([
            'nmCliente' => 'Junior',
            'telefone' => '(32) 91515-1515',
            'email' => 'junior@teste.com',
            'senha' => '123456'
        ]);

        ModelClient::create([
            'nmCliente' => 'Fabiana',
            'telefone' => '(33) 98484-8484',
            'email' => 'fabiana@teste.com',
            'senha' => '123456'
        ]);

        ModelClient::create([
            'nmCliente' => 'Heitor',
            'telefone' => '(31) 96262-6262',
            'email' => 'heitor@teste.com',
            'senha' => '123456'
        ]);

    }
}

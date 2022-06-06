<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'name' => 'Admin',
            'email' => 'odanielperez@ucundinamarca.edu.co',
            'password' => Hash::make('123456'),
            'rol' => 1,
            'apellidos' => 'Administrador',
            'numero_identificacion' => '1016436871',
            'direccion' => 'Calle falsa 123',
            'ciudad_id' => 1,
            'sucursal_id' => 1
        ]);
    }
}

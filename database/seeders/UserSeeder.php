<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UsuariosModel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = new UsuariosModel();
        $usuario->usuario_apater = 'SANTE';
        $usuario->usuario_amater = 'BARRERA';
        $usuario->usuario_nombres = 'FIDEL';
        $usuario->usuario_codigo = '70451069';
        $usuario->usuario_password = '$2y$10$8tEWkmHZ/fd6hf3OHGakyuvTdO6YfGox.07/LTlnzkbWsRxoWvD7S';
        $usuario->estado = '1';
        $usuario->save();
    }
}

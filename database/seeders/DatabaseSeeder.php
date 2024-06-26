<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BaseSeeder::class,
            TrackingProcesoSeeder::class,
            TrackingEstadoSeeder::class,
            DiaSemanaSeeder::class,
            MesSeeder::class,
            NivelJerarquicoSeeder::class,
            SedeLaboralSeeder::class,
        ]);
    }
}
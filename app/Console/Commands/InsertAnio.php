<?php

namespace App\Console\Commands;

use App\Models\Anio;
use Illuminate\Console\Command;

class InsertAnio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:insert-anio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta nuevo año';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Anio::create([
            'cod_anio' => date('Y'),
            'estado' => 1,
            'fec_reg' => now(),
            'fec_act' => now()
        ]);
        $this->info('Año insertado correctamente.');
        return 0;
    }
}

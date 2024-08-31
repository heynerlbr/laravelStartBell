<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PreoperacionalesController;
use Illuminate\Support\Facades\Log;

class nopreoperacional extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nopreoperacional';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta correo para enviar el informe de placa que no hicieron preoperacional';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Log::info('Iniciando tarea preDiario'); // Registro de inicio

            $PreoperacionalesController = new PreoperacionalesController();
            $PreoperacionalesController->EnvioCorreoPlacasNoPreoperacional();

            // Log::info('Tarea preDiario completada'); // Registro de finalización
        } catch (\Exception $e) {
            // Log::error('Error en tarea preDiario: ' . $e->getMessage()); // Registro de errores
            return 1; // Retornar un código de error
        }

        return 0; // Retornar un código de éxito
    }
}

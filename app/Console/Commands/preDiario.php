<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PreoperacionalesController;
use Illuminate\Support\Facades\Log;

class preDiario extends Command
{
    protected $signature = 'preDiario'; // Considera agregar argumentos u opciones si es necesario
    protected $description = 'Ejecuta tareas preoperacionales diarias'; // Descripción actualizada

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Log::info('Iniciando tarea preDiario'); // Registro de inicio

            $PreoperacionalesController = new PreoperacionalesController();
            $PreoperacionalesController->EnvioPreoperacionalesRealizados();

            // Log::info('Tarea preDiario completada'); // Registro de finalización
        } catch (\Exception $e) {
            // Log::error('Error en tarea preDiario: ' . $e->getMessage()); // Registro de errores
            return 1; // Retornar un código de error
        }

        return 0; // Retornar un código de éxito
    }
}

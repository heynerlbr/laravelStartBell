<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use  App\Http\Controllers\PreoperacionalesController;

class EnvioDiarioPreoperacional extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preDiario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta tarea es para enviar los preoperacionales diarios de cada empresa';

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
       $PreoperacionalesController=new PreoperacionalesController();
       $PreoperacionalesController->EnvioPreoperacionalesRealizados();
    }
}

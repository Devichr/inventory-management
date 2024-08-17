<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PredictionController;

class GeneratePredictions extends Command
{
    protected $signature = 'predictions:generate';
    protected $description = 'Generate predictions for fabric usage';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = new PredictionController();
        $controller->generatePredictions();

        $this->info('Predictions have been generated successfully.');
    }
}


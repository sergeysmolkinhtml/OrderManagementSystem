<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BoostPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boost-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the cached views, configs and routes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear cache
        $this->call('optimize:clear');

        // Cache again
        $this->call('optimize');

        $this->info('Optimization done: <info>✔</info>');
    }
}

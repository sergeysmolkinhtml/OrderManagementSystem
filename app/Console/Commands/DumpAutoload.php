<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Log;

class DumpAutoload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dump-autoload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate composer autoload files';

    /**
     * The Composer instance.
     *
     * @var Composer
     */
    protected Composer $composer;

    /**
     * Create a new command instance.
     *
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        Log::info('Dump autoload command was called.');

        $this->composer->dumpAutoloads('--optimize');
    }
}

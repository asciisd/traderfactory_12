<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlushBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flush:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all build files.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        exec('rm -rf '.public_path('build'));

        exec('rm -rf '.base_path('bootstrap/ssr'));

        $this->info('Build folder have been cleared!');
    }
}

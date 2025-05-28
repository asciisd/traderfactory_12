<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlushAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flush:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush Redis, Build, Log and Optimize Cache.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('flush:redis');
//        $this->call('flush:build');
        $this->call('flush:log');
        $this->call('optimize:clear');
    }
}

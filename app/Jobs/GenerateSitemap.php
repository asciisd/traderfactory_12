<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = public_path('sitemap.xml');
        SitemapGenerator::create(config('app.name').'/')->writeToFile($path);
    }
}

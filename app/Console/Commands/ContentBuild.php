<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ContentBuild extends Command
{
    protected $signature = 'content:build';
    protected $description = 'Clear content cache and regenerate search index';

    public function handle(): int
    {
        $this->info('Clearing content cache...');
        Cache::flush();
        $this->info('Cache cleared.');

        $this->call('search:index');

        $this->info('Content build complete.');
        return Command::SUCCESS;
    }
}

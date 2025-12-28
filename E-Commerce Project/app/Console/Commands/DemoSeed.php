<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DemoSeed extends Command
{
    protected $signature = 'demo:seed';
    protected $description = 'Seed demo data for Kinetiq';

    public function handle(): int
    {
        Artisan::call('db:seed', ['--force' => true]);
        $this->info('Demo data seeded.');
        return self::SUCCESS;
    }
}

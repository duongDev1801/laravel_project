<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:seed {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seeding for module';

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
        $module = $this->argument('name');
        Artisan::call('db:seed', [
            '--class' => "Modules\\{$module}\\Database\\Seeders\\{$module}Seeder"
        ]);
        $this->info("Seeding completed for module: {$module}");

        return 0;
    }
}

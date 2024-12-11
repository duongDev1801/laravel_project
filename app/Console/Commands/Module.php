<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class Module extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name} {--f|full : Create full files}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create module CLI';

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
        $name = $this->argument('name');
        $isCreateFull = $this->option('full');


        if (File::exists(base_path('modules/' . $name))) {
            $this->error('Module already exists!');
        } else {
            File::makeDirectory(base_path('modules/' . $name), 0755, true, true);

            //config
            $configFolder = base_path('modules/' . $name . '/configs');

            if (!File::exists($configFolder)) {
                File::makeDirectory($configFolder, 0755, true, true);
            }

            //helper
            $helperFolder = base_path('modules/' . $name . '/helpers');

            if (!File::exists($helperFolder)) {
                File::makeDirectory($helperFolder, 0755, true, true);
            }

            //database
            $this->handleMakeDatabaseFolder($name, $isCreateFull);

            $resourcesFolder = base_path('modules/' . $name . '/resources');

            if (!File::exists($resourcesFolder)) {
                File::makeDirectory($resourcesFolder, 0755, true, true);

                //language
                $languageFolder = base_path('modules/' . $name . '/resources/lang');

                if (!File::exists($languageFolder)) {
                    File::makeDirectory($languageFolder, 0755, true, true);
                }

                //views
                $viewsFolder = base_path('modules/' . $name . '/resources/views');

                if (!File::exists($viewsFolder)) {
                    File::makeDirectory($viewsFolder, 0755, true, true);
                }
            }

            //routes
            $routesFolder = base_path('modules/' . $name . '/routes');

            if (!File::exists($routesFolder)) {
                File::makeDirectory($routesFolder, 0755, true, true);

                //Tạo file web.php
                $routesWebFile = base_path('modules/' . $name . '/routes/web.php');

                //Tạo file api.php
                $routesApiFile = base_path('modules/' . $name . '/routes/api.php');

                $routeContent = File::get(app_path('Console/Commands/Templates/Route.txt'));
                $routeContent = str_replace('{module}', strtolower($name), $routeContent);
                $routeContent = str_replace('{controller}', $name, $routeContent);
                if (!File::exists($routesWebFile)) {
                    File::put($routesWebFile, $routeContent);
                }

                if (!File::exists($routesApiFile)) {
                    File::put($routesApiFile, $routeContent);
                }
            }

            //src
            $srcFolder = base_path('modules/' . $name . '/src');

            if (!File::exists($srcFolder)) {
                File::makeDirectory($srcFolder, 0755, true, true);

                //Commands
                $commandsFolder = base_path('modules/' . $name . '/src/Commands');

                if (!File::exists($commandsFolder)) {
                    File::makeDirectory($commandsFolder, 0755, true, true);
                }

                //Http
                $httpFolder = base_path('modules/' . $name . '/src/Http');

                if (!File::exists($httpFolder)) {
                    File::makeDirectory($httpFolder, 0755, true, true);

                    //Controllers
                    $controllersFolder = base_path('modules/' . $name . '/src/Http/Controllers');

                    if (!File::exists($controllersFolder)) {
                        File::makeDirectory($controllersFolder, 0755, true, true);
                    }

                    //Middlewares
                    $middlewaresFolder = base_path('modules/' . $name . '/src/Http/Middlewares');

                    if (!File::exists($middlewaresFolder)) {
                        File::makeDirectory($middlewaresFolder, 0755, true, true);
                    }
                }

                //Models
                $this->handleMakeModelFolder($name, $isCreateFull);


                //Repositories
                $repositoriesFolder = base_path('modules/' . $name . '/src/Repositories');

                if (!File::exists($repositoriesFolder)) {
                    File::makeDirectory($repositoriesFolder, 0755, true, true);

                    //ModuleRepositoryInterface
                    $moduleRepositoryInterface = base_path('modules/' . $name . '/src/Repositories/' . $name . 'RepositoryInterface.php');
                    if (!File::exists($moduleRepositoryInterface)) {
                        $moduleRepositoryInterfaceFileContent = file_get_contents(app_path('Console/Commands/Templates/ModuleRepositoryInterface.txt'));
                        $moduleRepositoryInterfaceFileContent = str_replace('{module}', $name, $moduleRepositoryInterfaceFileContent);
                        File::put($moduleRepositoryInterface, $moduleRepositoryInterfaceFileContent);
                    }

                    //ModuleRepository
                    $moduleRepository = base_path('modules/' . $name . '/src/Repositories/' . $name . 'Repository.php');
                    if (!File::exists($moduleRepository)) {
                        $moduleRepositoryFileContent = file_get_contents(app_path('Console/Commands/Templates/ModuleRepository.txt'));
                        $moduleRepositoryFileContent = str_replace('{module}', $name, $moduleRepositoryFileContent);
                        File::put($moduleRepository, $moduleRepositoryFileContent);
                    }
                }

            }

            $this->info('Module created successfully!');
        }
    }

    private function handleMakeDatabaseFolder($name, $isCreateFull)
    {
        $databaseFolder = base_path('modules/' . $name . '/database');
        if (!File::exists($databaseFolder)) {
            File::makeDirectory($databaseFolder, 0755, true, true);

            //migrations
            $migrationsFolder = $databaseFolder . '/migrations';
            File::makeDirectory($migrationsFolder, 0755, true, true);
            if ($isCreateFull) {
                $migrationsFileTemplatePath = app_path('Console/Commands/Templates/Migration.txt');
                $migrationsFileContent = File::get($migrationsFileTemplatePath);
                $classMigrationsName = 'Create' . $name . 'sTable';
                $table = strtolower($name);
                $classMigrationsName = 'Create' . $name . 'sTable';
                if (substr($name, -1) == 'y') {
                    $table = substr($name, 0, -1) . 'ies';
                    $table = strtolower($table);
                    $classMigrationsName = 'Create' . ucfirst($table) . 'Table';

                }

                $migrationsFileContent = str_replace('{className}', $classMigrationsName, $migrationsFileContent);
                $migrationsFileContent = str_replace('{table}', strtolower($table), $migrationsFileContent);
                $migrationsName = Carbon::now()->format('Y_m_d_His') . '_create_' . $table . '_table.php';
                File::put($migrationsFolder . '/' . $migrationsName, $migrationsFileContent);
                $this->info('Migrations created successfully!');

            }

            //seeder 
            $seedersFolder = $databaseFolder . '/seeders';
            if ($isCreateFull) {
                File::makeDirectory($seedersFolder, 0755, true, true);
                $seedersFileTemplatePath = app_path('Console/Commands/Templates/Seeder.txt');
                $seedersFileContent = File::get($seedersFileTemplatePath);
                $className = $name . 'Seeder';
                $seedersFileContent = str_replace('{className}', $className, $seedersFileContent);
                File::put($seedersFolder . '/' . $className . '.php', $seedersFileContent);
                $this->info('Seeders created successfully!');
            }

            $factoriesFolder = $databaseFolder . '/factories';

            if ($isCreateFull) {
                File::makeDirectory($factoriesFolder, 0755, true, true);
                $factoriesFileTemplatePath = app_path('Console/Commands/Templates/Factory.txt');
                $factoriesFileContent = File::get($factoriesFileTemplatePath);
                $className = $name . 'Factory';
                $factoriesFileContent = str_replace('{className}', $className, $factoriesFileContent);
                $factoriesFileContent = str_replace('{module}', $name, $factoriesFileContent);
                $factoriesFileContent = str_replace('{modelName}', $name, $factoriesFileContent);
                File::put($factoriesFolder . '/' . $className . '.php', $factoriesFileContent);
                $this->info('Factory created successfully!');
            }

        }
    }

    private function handleMakeModelFolder($name, $isCreateFull)
    {
        $modelsFolder = base_path('modules/' . $name . '/src/Models');

        if (!File::exists($modelsFolder)) {
            File::makeDirectory($modelsFolder, 0755, true, true);
            if ($isCreateFull) {
                $modelFileTemplatePath = app_path('Console/Commands/Templates/Model.txt');
                $modelFileContent = File::get($modelFileTemplatePath);
                $modelFileContent = str_replace('{module}', $name, $modelFileContent);
                $modelFileContent = str_replace('{className}', $name, $modelFileContent);
                File::put($modelsFolder . '/' . $name . '.php', $modelFileContent);
                $this->info('Model created successfully');

            }
        }
    }
}

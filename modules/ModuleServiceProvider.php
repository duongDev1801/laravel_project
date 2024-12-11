<?php

namespace Modules;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Modules\User\src\Commands\TestCommand;
use Modules\User\src\Http\Middlewares\demoMiddleware;
use Modules\User\src\Repositories\UserRepository;
use Modules\User\src\Repositories\UserRepositoryInterface;

class ModuleServiceProvider extends ServiceProvider
{
  private $middlewares = ['demo' => demoMiddleware::class];
  private $command = [
      // namespace của commands đặt tại đây
    TestCommand::class
  ];

  public function boot()
  {
    $modules = $this->getModules();
    if (!empty($modules)) {
      foreach ($modules as $module) {
        $this->registerModule($module);
      }
    }
  }

  public function register()
  {
    //declare config
    $modules = $this->getModules();
    if (!empty($modules)) {
      foreach ($modules as $module) {
        $this->registerConfig($module);
      }
    }

    //declare middlewares

    $this->registerMiddleware();

    //Commands
    $this->commands($this->command);

    $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
  }

  private function registerConfig($module)
  {
    $configPath = __DIR__ . '/' . $module . '/configs';
    if (File::exists($configPath)) {
      $configFiles = array_map('basename', File::allFiles($configPath));
      foreach ($configFiles as $config) {
        $alias = basename($config, '.php');

        $this->mergeConfigFrom($configPath . '/' . $config, $alias);
      }
    }
  }

  private function registerMiddleware()
  {
    if (!empty($this->middlewares)) {
      foreach ($this->middlewares as $key => $middleware) {
        $this->app['router']->pushMiddlewareToGroup($key, $middleware);
      }
    }
  }

  private function getModules()
  {
    return array_map('basename', File::directories(__DIR__));
  }

  private function registerModule($module)
  {
    $modulePath = __DIR__ . "/{$module}";

    //declare route
    $routePath = $modulePath . '/routes/routes.php';
    if (File::exists($routePath)) {
      $this->loadRoutesFrom($routePath);
    }

    //declare migrations
    $migrationsPath = $modulePath . '/database/migrations';
    if (File::exists($migrationsPath)) {
      $this->loadMigrationsFrom($migrationsPath);
    }

    //declare languages
    $languagesPath = $modulePath . '/resources/languages';
    if (File::exists($languagesPath)) {
      $this->loadTranslationsFrom($languagesPath, strtolower($module));
      $this->loadJsonTranslationsFrom($languagesPath);
    }

    //declare view 
    $viewsPath = $modulePath . '/resources/views';
    if (File::exists($viewsPath)) {
      $this->loadViewsFrom($viewsPath, strtolower($module));
    }

    //declare helper
    $helpersPath = $modulePath . '/helpers';
    $helperList = File::allFiles($helpersPath);
    foreach ($helperList as $key => $value) {
      $file = $value->getPathname();
      require $file;
    }


  }
}

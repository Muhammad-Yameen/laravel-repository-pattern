<?php

namespace Contract\Repo;

use Illuminate\Support\ServiceProvider;
use Contract\Repo\Console\Commands\GenerateInterface;
use Contract\Repo\Console\Commands\GenerateRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateRepository::class,
                GenerateInterface::class,
            ]);
        }
    }

    public function register()
    {
        
    }
}
